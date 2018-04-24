using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using MySql.Data.MySqlClient;

namespace ShadowNova
{
    class Holding
    {
        public int pid { get; set; }
        int hid;
        int food;
        int rawMat;
        int energy;
        bool upgrade1;
        bool upgrade2;
        bool upgrade3;
        bool upgrade4;


        //Default Constructor Generates Random Values
        public Holding()
        {
            bool[] option = new[] { true, false };

            //Identifiers //Edit out if we shift this to be a list inside house or planet class.
            pid = Program.r.Next(1, Global.highPID);
            hid = Program.r.Next(1, Global.highHID);

            while (Global.holdingList.Exists(y => (y.pid == pid) && (y.hid == hid)))
            {
                pid = Program.r.Next(1, Global.highPID);
                hid = Program.r.Next(1, Global.highHID);
            }


            //Resources
            food = Program.r.Next(1, 500);
            rawMat = Program.r.Next(1, 500);
            energy = Program.r.Next(1, 500);

            //Upgrades
            upgrade1 = option[Program.r.Next(0, 1)];
            upgrade2 = option[Program.r.Next(0, 1)];
            upgrade3 = option[Program.r.Next(0, 1)];
            upgrade4 = option[Program.r.Next(0, 1)];
            Global.highHold++;
        }

        //If you have a specific planet that you want created, lets you feed everything in.
        public Holding(int pid, int hid, int food, int rawMat, int energy, bool upgrade1, bool upgrade2, bool upgrade3, bool upgrade4)
        {
            this.pid = pid;
            this.hid = hid;
            this.food = food;
            this.rawMat = rawMat;
            this.energy = energy;
            this.upgrade1 = upgrade1;
            this.upgrade2 = upgrade2;
            this.upgrade3 = upgrade3;
            this.upgrade4 = upgrade4;
            Global.highHold++;
        }

        //Helper for save and load functions. Not strictly required, but nice way to create a dummy.
        public Holding(bool x)
        {
            this.pid = 0;
            this.hid = 0;
            this.food = 0;
            this.rawMat = 0;
            this.energy = 0;
            this.upgrade1 = false;
            this.upgrade2 = false;
            this.upgrade3 = false;
            this.upgrade4 = false;
        }

        public void print(int pid, int hid)
        {
            int i = Global.holdingList.FindIndex(y => (y.pid == pid) && (y.hid == hid));
            Console.WriteLine("HID: {0}\nFood: {1}\nMinerals: {2}\nEnergy: {3}\nUpgrade1: {4}\nUpgrade2: {5}\nUpgrade3: {6}\nUpgrade4: {7}"
                , Global.holdingList[i].hid, Global.holdingList[i].food, Global.holdingList[i].rawMat, Global.holdingList[i].energy,
                Global.holdingList[i].upgrade1, Global.holdingList[i].upgrade2, Global.holdingList[i].upgrade3, Global.holdingList[i].upgrade4);
            //Finish this.
        }

        public void loadHolding() //Left here
        {
            var dbCon = DBConnection.Instance();
            dbCon.DatabaseName = "myDB";
            if (dbCon.IsConnect())
            {
                Console.WriteLine("Loading Holding Data");
                string query = "SELECT pid, hid, food, rawMat, energy, upgrade1, upgrade2, upgrade3, upgrade4 FROM planet_holding";
                var cmd = new MySqlCommand(query, dbCon.Connection);
                var reader = cmd.ExecuteReader();
                Holding holding;
                while (reader.Read())
                {
                    //read each holding in and add to list. Change to find correct pid/hid if stored in those objects
                    holding = new Holding(reader.GetInt32(0), reader.GetInt32(1),
                    reader.GetInt32(2), reader.GetInt32(3), reader.GetInt32(4),
                    reader.GetBoolean(5), reader.GetBoolean(6), reader.GetBoolean(7),
                    reader.GetBoolean(8));
                    Global.holdingList.Add(holding);
                }
                Console.WriteLine("Loaded Holdings");
                reader.Close();
                dbCon.Close();
            }
        }

        public void saveHolding()
        {
            var dbCon = DBConnection.Instance();
            dbCon.DatabaseName = "myDB";
            string query = "";
            var cmd = new MySqlCommand(query, dbCon.Connection);

            if (dbCon.IsConnect())
            {
                Console.WriteLine("Saving Holding Data to Database");
                //Planet
                for (int j = 0; j < Global.holdingList.Count(); j++)
                {
                    query = String.Format("INSERT INTO planet_holding (pid, hid, food, rawMat, energy, upgrade1, upgrade2, upgrade3, upgrade4)" +
                        " VALUES ('{0}', '{1}', '{2}', '{3}', '{4}', '{5}', '{6}', '{7}', '{8}') " +
                        "ON DUPLICATE KEY UPDATE " +
                        "food='{2}', " +
                        "rawMat='{3}', " +
                        "energy='{4}', " +
                        "upgrade1='{5}', " +
                        "upgrade2='{6}', " +
                        "upgrade3='{7}', " +
                        "upgrade4='{8}'",
                        Global.holdingList[j].pid,
                        Global.holdingList[j].hid,
                        Global.holdingList[j].food,
                        Global.holdingList[j].rawMat,
                        Global.holdingList[j].energy,
                        Global.holdingList[j].upgrade1,
                        Global.holdingList[j].upgrade2,
                        Global.holdingList[j].upgrade3,
                        Global.holdingList[j].upgrade4);
                    cmd = new MySqlCommand(query, dbCon.Connection);
                    cmd.ExecuteNonQuery();
                }
                Console.WriteLine("Holding Data Saved.");
                dbCon.Close();
            }
        }
    }
}
