using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using MySql.Data.MySqlClient;

namespace ShadowNova
{
    class Planet
    {
        public int pid;
        public string name;
        public int locX;
        public int locY;
        public int size;
        public string terrain;
        public string secTerrain;
        public string descript;
        public int expLabour;
        public int genLabour;
        public int totalPop;
        public int minerals;
        public int popGrowth;
        public int wealth;
        public int eduLevel;

        //Default Constructor Generates Random Values
        public Planet()
        {
            string[] option;

            pid = ++Global.highPID;
            name = "Test" + pid;

            //Creates coordinates and checks if they are taken, if so, rerolls them.
            int locXa = Program.r.Next(-Global.galaxySize / 2, Global.galaxySize / 2);
            int locYa = Program.r.Next(-Global.galaxySize / 2, Global.galaxySize / 2);
            while (Global.planetList.Exists(y => (y.locY == locYa) && (y.locX == locXa)))
            {
                locXa = Program.r.Next(-Global.galaxySize / 2, Global.galaxySize / 2);
                locYa = Program.r.Next(-Global.galaxySize / 2, Global.galaxySize / 2);
            }
            locX = locXa;
            locY = locYa;

            size = Program.r.Next(1, 10);

            //Terrain Generation
            option = new[] { "Arid", "Desert", "Savanna", "Alpine", "Arctic", "Tundra", "Continental", "Ocean", "Tropical" };
            terrain = option[Program.r.Next(0, 8)];
            option = new[] { "Dry", "Frozen", "Verdant", "Wet", "Barren", "", "", "", "", "", "" };
            secTerrain = option[Program.r.Next(0, 10)];

            //General Stats
            descript = "The Planet was the " + pid + "th planet to be created.";
            expLabour = Program.r.Next(1, 10);
            genLabour = Program.r.Next(1, 10);
            totalPop = expLabour + genLabour; //This will be more than these values later.
            minerals = Program.r.Next(1, 10); //Refactor to be mineralDeposit later.
            popGrowth = Program.r.Next(1, 10); //probably a factor of food surplus right now
            wealth = Program.r.Next(1, 10); //Not sure how to calc
            eduLevel = Program.r.Next(1, 10); //Not likely to matter in the end.
        }

        //If you have a specific planet that you want created, lets you feed everything in.
        public Planet(int pid, string name, int locX, int locY, int size, string terrain, string secTerrain, string descript, int expLabour
            , int genLabour, int totalPop, int minerals, int popGrowth, int wealth, int eduLevel)
        {
            this.pid = pid;
            this.name = name;
            this.locX = locX;
            this.locY = locY;
            this.size = size;
            this.terrain = terrain;
            this.secTerrain = secTerrain;
            this.descript = descript;
            this.expLabour = expLabour;
            this.genLabour = genLabour;
            this.totalPop = totalPop;
            this.minerals = minerals;
            this.popGrowth = popGrowth;
            this.wealth = wealth;
            this.eduLevel = eduLevel;
        }

        //Helper for save and load functions. Not strictly required, but nice way to create a dummy.
        public Planet(bool x)
        {
            this.pid = 0;
            this.name = "";
            this.locX = 0;
            this.locY = 0;
            this.size = 0;
            this.terrain = "";
            this.secTerrain = "";
            this.descript = "";
            this.expLabour = 0;
            this.genLabour = 0;
            this.totalPop = 0;
            this.minerals = 0;
            this.popGrowth = 0;
            this.wealth = 0;
            this.eduLevel = 0;
        }

        public void loadPlanet()
        {
            var dbCon = DBConnection.Instance();
            dbCon.DatabaseName = "myDB";
            if (dbCon.IsConnect())
            {
                Console.WriteLine("Loading Planet Data");
                string query = "SELECT pid, name, locX, locY, size, terrain, secTerrain, descript, expLabour, " +
                    "genLabour, totalPop, minerals, popGrowth, wealth, eduLevel FROM planet"; //Looking for current highest pid.
                var cmd = new MySqlCommand(query, dbCon.Connection);
                var reader = cmd.ExecuteReader();
                Planet planet;
                while (reader.Read())
                {
                    //Reads each planet's info in, row by row.
                    planet = new Planet(reader.GetInt32(0), reader.GetString(1),
                    reader.GetInt32(2), reader.GetInt32(3), reader.GetInt32(4),
                    reader.GetString(5), reader.GetString(6), reader.GetString(7),
                    reader.GetInt32(8), reader.GetInt32(9), reader.GetInt32(10),
                    reader.GetInt32(11), reader.GetInt32(12), reader.GetInt32(13),
                    reader.GetInt32(14));
                    Global.planetList.Add(planet);
                    Global.highPID = reader.GetInt32(0);
                }
                Console.WriteLine("Loaded Planets");
                reader.Close();
                dbCon.Close();
            }
        }

        public void savePlanet()
        {
            var dbCon = DBConnection.Instance();
            dbCon.DatabaseName = "myDB";
            string query = "";
            var cmd = new MySqlCommand(query, dbCon.Connection);

            if (dbCon.IsConnect())
            {
                Console.WriteLine("Saving Planet Data to Database");
                //Planet
                for (int j = 0; j < Global.planetList.Count(); j++)
                {
                    query = String.Format("INSERT INTO planet (pid, name, locX, locY, size, terrain, secTerrain, descript," +
                        " expLabour, genLabour, totalPop, minerals, popGrowth, wealth, eduLevel)" +
                        " VALUES ('{0}', '{1}', '{2}', '{3}', '{4}', '{5}', '{6}', '{7}', '{8}', '{9}', '{10}', '{11}', '{12}', '{13}', '{14}') " +
                        "ON DUPLICATE KEY UPDATE " +
                        "name='{1}', " +
                        "locX='{2}', " +
                        "locY='{3}', " +
                        "size='{4}', " +
                        "terrain='{5}', " +
                        "secTerrain='{6}', " +
                        "descript='{7}', " +
                        "expLabour='{8}', " +
                        "genLabour='{9}', " +
                        "totalPop='{10}', " +
                        "minerals='{11}', " +
                        "popGrowth='{12}', " +
                        "wealth='{13}', " +
                        "eduLevel='{14}'",
                        Global.planetList[j].pid,
                        Global.planetList[j].name,
                        Global.planetList[j].locX,
                        Global.planetList[j].locY,
                        Global.planetList[j].size,
                        Global.planetList[j].terrain,
                        Global.planetList[j].secTerrain,
                        Global.planetList[j].descript,
                        Global.planetList[j].expLabour,
                        Global.planetList[j].genLabour,
                        Global.planetList[j].totalPop,
                        Global.planetList[j].minerals,
                        Global.planetList[j].popGrowth,
                        Global.planetList[j].wealth,
                        Global.planetList[j].eduLevel);
                    cmd = new MySqlCommand(query, dbCon.Connection);
                    cmd.ExecuteNonQuery();
                }
                Console.WriteLine("Planet Data Saved.");
                dbCon.Close();
            }
        }
    }
}
