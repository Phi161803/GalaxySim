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

            //Planet locations
            fPlanet = Program.r.Next(1, Global.highPID);
            sPlanet = Program.r.Next(1, Global.highPID);

            while ((Global.laneList.Exists(y => (y.fPlanet == fPlanet) && (y.sPlanet == sPlanet))) && 
                (Global.laneList.Exists(y => (y.fPlanet == sPlanet) && (y.sPlanet == fPlanet))) 
                && (fPlanet != sPlanet))
            {
                fPlanet = Program.r.Next(1, Global.highPID);
                sPlanet = Program.r.Next(1, Global.highPID);
            }

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
}
