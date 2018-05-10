using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using MySql.Data.MySqlClient;

namespace ShadowNova
{
    class MilitaryUnit
    {
        public int mid;
        public string name;
        public int owner;
        public int commander;
        public bool defMob;
        public bool type;
        public int points;
        public int exp;
        public bool active;
        public int camp;
        public int loc;

        //Default Constructor Generates Random Values 
        public MilitaryUnit()
        {
            mid = ++Global.highMID;
            name = "Unit " + mid.ToString("D3"); //Left-pads name, e.g. mid = 4 produces name = "Unit 004".
            owner = Program.r.Next(1, Global.highHID);
            commander = 0;
            defMob = false;
            type = false;
            points = Program.r.Next(0, 999);
            exp = Program.r.Next(0, 999);
            active = false;
            camp = 0;
            loc = Program.r.Next(1, Global.highPID);
        }

        public MilitaryUnit(int a)
        {
            mid = ++Global.highMID;
            name = "Unit " + mid.ToString("D3"); //Left-pads name, e.g. mid = 4 produces name = "Unit 004".
            owner = a;
            commander = 0;
            defMob = false;
            type = false;
            points = Program.r.Next(0, 999);
            exp = Program.r.Next(0, 999);
            active = false;
            camp = 0;
            loc = Program.r.Next(1, Global.highPID);
            Console.WriteLine("owner cons int:" + owner);
        }

        //If you have a specific actor that you want created, lets you feed everything in.  
        public MilitaryUnit(int mid, string name, int owner, int commander, bool defMob, bool type, int points, int exp, bool active, int camp, int loc)
        {
            this.mid = mid;
            this.name = name;
            this.owner = owner;
            this.commander = commander;
            this.defMob = defMob;
            this.type = type;
            this.points = points;
            this.exp = exp;
            this.active = active;
            this.camp = camp;
            this.loc = loc;
            Console.WriteLine("owner cons all:" + owner);
        }

        //Helper for save and load functions. Not strictly required, but nice way to create a dummy.
        public MilitaryUnit(bool x)
        {
            mid = 0;
            name = "";
            owner = 0;
            commander = 0;
            defMob = false;
            type = false;
            points = 0;
            exp = 0;
            active = false;
            camp = 0;
            loc = 0;
        }

        public void loadMilitaryUnit()
        {
            var dbCon = DBConnection.Instance();
            dbCon.DatabaseName = "myDB";
            if (dbCon.IsConnect())
            {
                Console.WriteLine("Loading MilitaryUnit Data");
                string query = "SELECT mid, name, owner, commander, defMob, type, points, exp, active, camp, loc FROM militaryunit"; //Looking for current highest mid.
                var cmd = new MySqlCommand(query, dbCon.Connection);
                var reader = cmd.ExecuteReader();
                MilitaryUnit militaryUnit;
                while (reader.Read())
                {
                    //Reads each militaryunit's info in, row by row.
                    militaryUnit = new MilitaryUnit(reader.GetInt32(0), reader.GetString(1), reader.GetInt32(2),
                    reader.GetInt32(3), reader.GetBoolean(4), reader.GetBoolean(5),
                    reader.GetInt32(6), reader.GetInt32(7), reader.GetBoolean(8),
                    reader.GetInt32(9), reader.GetInt32(10));
                    Global.unitList.Add(militaryUnit);
                    Global.highMID = reader.GetInt32(0);
                    Console.WriteLine("owner:" + owner);
                }
                Console.WriteLine("Loaded MilitaryUnits");
                reader.Close();
                dbCon.Close();
            }
        }

        public void saveMilitaryUnit()
        {
            var dbCon = DBConnection.Instance();
            dbCon.DatabaseName = "myDB";
            string query = "";
            var cmd = new MySqlCommand(query, dbCon.Connection);

            if (dbCon.IsConnect())
            {
                Console.WriteLine("Saving MilitaryUnit Data to Database");
                //MilitaryUnit
                for (int j = 0; j < Global.unitList.Count(); j++)
                {
                    query = String.Format("INSERT INTO militaryunit (mid, name, owner, commander, defMob, type, points, exp, active, camp, loc)" +
                        " VALUES ('{0}', '{1}', '{2}', '{3}', '{4}', '{5}', '{6}', '{7}', '{8}', '{9}', '{10}') " +
                        "ON DUPLICATE KEY UPDATE " +
                        "owner='{2}', " +
                        "name='{1}', " +
                        "commander='{3}', " +
                        "defMob='{4}', " +
                        "type='{5}', " +
                        "points='{6}', " +
                        "exp='{7}', " +
                        "active='{8}', " +
                        "camp='{9}'," +
                        "loc='{10}'",
                        Global.unitList[j].mid,
                        Global.unitList[j].name,
                        Global.unitList[j].owner,
                        Global.unitList[j].commander,
                        Convert(Global.unitList[j].defMob),
                        Convert(Global.unitList[j].type),
                        Global.unitList[j].points,
                        Global.unitList[j].exp,
                        Convert(Global.unitList[j].active),
                        Global.unitList[j].camp,
                        Global.unitList[j].loc);
                    cmd = new MySqlCommand(query, dbCon.Connection);
                    cmd.ExecuteNonQuery();
                }
                Console.WriteLine("MilitaryUnit Data Saved.");
                dbCon.Close();
            }
        }

        public int Convert(bool a)
        {
            if (a == false) { return 0; }
            if (a == true) { return 1; }
            return 0;
        }
    }
}