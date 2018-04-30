using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using MySql.Data.MySqlClient;

namespace ShadowNova
{
    class Starlane
    {
        public int slid { get; set; }
        int fPlanet; //first planet
        int flocX;
        int flocY;
        int sPlanet; //second planet
        int slocX;
        int slocY;
        bool pub;
        //Add strength/health later.
        public List<int> known = new List<int>(); //This should be null if pub is true; Could make checks just check for null here?

        //Default Constructor Generates Random Values
        public Starlane()
        {
            bool[] option = new[] { true, false };

            slid = ++Global.highSLID;

            flocX = Global.planetList[fPlanet].locX;
            flocY = Global.planetList[fPlanet].locY;
            slocX = Global.planetList[sPlanet].locX;
            slocY = Global.planetList[sPlanet].locY;
            bool test = true;

            do
            {
                //Randomly generate planets
                fPlanet = Program.r.Next(1, Global.highPID);
                sPlanet = Program.r.Next(1, Global.highPID);

                //check for intersecting lanes.
                test = false;
                for (int i = 0; i < Global.highSLID - 1; i++)
                {
                    test = laneSect(flocX, flocY, slocX, slocY, Global.laneList[i]);
                    if (test == true) { break; }
                }

            } while ((Global.laneList.Exists(y => (y.fPlanet == fPlanet) && (y.sPlanet == sPlanet))) &&
                (Global.laneList.Exists(y => (y.fPlanet == sPlanet) && (y.sPlanet == fPlanet)))
                && (fPlanet != sPlanet) && test == false);


            flocX = Global.planetList[fPlanet].locX;
            flocY = Global.planetList[fPlanet].locY;
            slocX = Global.planetList[sPlanet].locX;
            slocY = Global.planetList[sPlanet].locY;

            pub = true;
            known = null;
        }

        public Starlane(int fpla)
        {
            bool[] option = new[] { true, false };

            slid = ++Global.highSLID;

            //Planet locations
            fPlanet = fpla;
            sPlanet = Program.r.Next(1, Global.highPID);

            while ((Global.laneList.Exists(y => (y.fPlanet == fPlanet) && (y.sPlanet == sPlanet))) &&
                (Global.laneList.Exists(y => (y.fPlanet == sPlanet) && (y.sPlanet == fPlanet)))
                && (fPlanet != sPlanet))
            {
                sPlanet = Program.r.Next(1, Global.highPID);
            }

            flocX = Global.planetList[fPlanet].locX;
            flocY = Global.planetList[fPlanet].locY;
            slocX = Global.planetList[sPlanet].locX;
            slocY = Global.planetList[sPlanet].locY;

            pub = true;
            known = null;
        }

        int min(int a, int b)
        {
            if (a < b) return a;
            return b;
        }

        int max(int a, int b)
        {
            if (a > b) return a;
            return b;
        }

        bool laneSect(int fx, int fy, int sx, int sy, Starlane b)
        {
            bool boxsect = false;
            bool lineSectAB = false;
            bool lineSectBA = false;

            //testing box
            boxsect = testbox(fx, fy, sx, sy, b);

            Point a1 = new Point(fx, fy);
            Point a2 = new Point(sx, sy);
            Point b1 = new Point(flocX, flocY);
            Point b2 = new Point(slocX, slocY);

            LineSegment l1 = new LineSegment(a1, a2);
            LineSegment l2 = new LineSegment(b1, b2);

            lineSectAB = lineSegmentTouchesOrCrossesLine(l1, l2);
            lineSectBA = lineSegmentTouchesOrCrossesLine(l2, l1);

            if (boxsect == true && lineSectAB == true && lineSectBA == true)
                return true;
            else return false;

            return boxsect && lineSectAB && lineSectBA;

        }

        public static double crossProduct(Point a, Point b)
        {
            return a.x * b.y - b.x * a.y;
        }

        public static bool isPointOnLine(LineSegment a, Point b)
        {
            // Move the image, so that a.first is on (0|0)
            LineSegment aTmp = new LineSegment(new Point(0, 0), new Point(
                    a.second.x - a.first.x, a.second.y - a.first.y));
            Point bTmp = new Point(b.x - a.first.x, b.y - a.first.y);
            double r = crossProduct(aTmp.second, bTmp);
            return Math.Abs(r) < 0.000001;
        }

        public static bool isPointRightOfLine(LineSegment a, Point b)
        {
            // Move the image, so that a.first is on (0|0)
            LineSegment aTmp = new LineSegment(new Point(0, 0), new Point(
                    a.second.x - a.first.x, a.second.y - a.first.y));
            Point bTmp = new Point(b.x - a.first.x, b.y - a.first.y);
            return crossProduct(aTmp.second, bTmp) < 0;
        }

        public static bool lineSegmentTouchesOrCrossesLine(LineSegment a,
                LineSegment b)
        {
            return isPointOnLine(a, b.first)
                    || isPointOnLine(a, b.second)
                    || (isPointRightOfLine(a, b.first) ^ isPointRightOfLine(a,
                            b.second));
        }

        bool testbox(int fx, int fy, int sx, int sy, Starlane b)
        {
            if ((max(fy, sy) > min(b.flocY, b.slocY))
                && (max(b.flocY, b.slocY) > min(fy, sy))
                && (max(fx, sx) > min(b.flocX, b.slocX))
                && (max(b.flocX, b.slocX) > min(fx, sx)))
            { return true; }
            return false;
        }

        //Create specific starlane. Add constructor to allow specific houses to see it later.
        public Starlane(int slid, int fPlanet, int sPlanet, bool pub)
        {
            this.slid = slid;
            this.fPlanet = fPlanet;
            this.sPlanet = sPlanet;
            this.pub = pub;
            flocX = Global.planetList[fPlanet].locX;
            flocY = Global.planetList[fPlanet].locY;
            slocX = Global.planetList[sPlanet].locX;
            slocY = Global.planetList[sPlanet].locY;
        }

        //Helper for save and load functions. Not strictly required, but nice way to create a dummy.
        public Starlane(bool x)
        {
            slid = 0;
            fPlanet = 0;
            sPlanet = 0;
            pub = false;
            flocX = 0;
            flocY = 0;
            slocX = 0;
            slocY = 0;
        }

        public void loadStarlane() //Does not read hidden yet.
        {
            var dbCon = DBConnection.Instance();
            dbCon.DatabaseName = "myDB";
            if (dbCon.IsConnect())
            {
                Console.WriteLine("Loading Starlane Data");
                string query = "SELECT slid, fPlanet, sPlanet, pub FROM starlane";
                var cmd = new MySqlCommand(query, dbCon.Connection);
                var reader = cmd.ExecuteReader();
                Starlane starlane;
                while (reader.Read())
                {
                    starlane = new Starlane(reader.GetInt32(0), reader.GetInt32(1),
                    reader.GetInt32(2), reader.GetBoolean(3));
                    Global.laneList.Add(starlane);
                    Global.highSLID++;
                }
                Console.WriteLine("Loaded Starlane");
                reader.Close();
                dbCon.Close();
            }
        }

        public void saveStarlane()
        {
            var dbCon = DBConnection.Instance();
            dbCon.DatabaseName = "myDB";
            string query = "";
            var cmd = new MySqlCommand(query, dbCon.Connection);

            if (dbCon.IsConnect())
            {
                Console.WriteLine("Saving Starlane Data to Database");
                //Planet
                for (int j = 0; j < Global.laneList.Count(); j++)
                {
                    //fplanet/splanet not reliable keys, since they can be inversed.
                    query = String.Format("INSERT INTO starlane (slid, fPlanet, flocX, flocY, sPlanet, slocX, slocY, pub)" +
                        " VALUES ('{0}', '{1}', '{2}', '{3}', '{4}', '{5}', '{6}', '{7}') " +
                        "ON DUPLICATE KEY UPDATE " +
                        "pub='{7}'",
                        Global.laneList[j].slid,
                        Global.laneList[j].fPlanet,
                        Global.laneList[j].flocX,
                        Global.laneList[j].flocY,
                        Global.laneList[j].sPlanet,
                        Global.laneList[j].slocX,
                        Global.laneList[j].slocY,
                        Global.laneList[j].known);
                    cmd = new MySqlCommand(query, dbCon.Connection);
                    cmd.ExecuteNonQuery();
                }
                Console.WriteLine("Starlane Data Saved.");
                dbCon.Close();
            }
        }
    }

    public class Point
    {
        public int x;
        public int y;

        public Point(int x, int y)
        {
            this.x = x;
            this.y = y;
        }
    }

    public class LineSegment
    {
        public Point first;
        public Point second;

        public LineSegment(Point a, Point b)
        {
            first = a;
            second = b;
        }
    }

}
