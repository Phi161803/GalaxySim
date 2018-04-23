using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using MySql.Data.MySqlClient;

namespace ShadowNova
{
    class Actor
    {
        public int cid;
        public string name;
        public int birth;
        public bool gender;
        public int health;
        public int preg;
        public int pregStart;
        public string descript;
        public int loc;
        public int owner;
        public int pos;
        public int intel;
        public int brawn;
        public int charisma;
        public int expMilitary;
        public int expAdmin;


        //Default Constructor Generates Random Values 
        public Actor()
        {
            string[] option;

            cid = ++Global.highCID;
            name = "Test" + cid;
            birth = Program.r.Next(0,999);
            if(Program.r.Next(0,1) == 1)
                gender = true;  // girl
            else
                gender = false; // boy
            health = Program.r.Next(0,100);
            preg = 0;
            pregStart = 0;
            descript = "This is a test description!";
            loc = Global.houseList[owner].home;
            owner = Program.r.Next(1, Global.highHID);
            pos = 0;
            intel = Program.r.Next(1,10);
            brawn = Program.r.Next(1,10);
            charisma = Program.r.Next(1,10);
            expMilitary = (0,999);
            expAdmin = (0,999);
        }

        //If you have a specific actor that you want created, lets you feed everything in.  
        public Actor(int cid, string name, int birth, bool gender, int health, int preg, int pregStart, string descript, int loc, int owner, int pos, int intel, int brawn, int charisma, int expMilitary, int expAdmin)
        {
            this.cid = cid;
            this.name = name;
            this.birth = birth;
            this.gender = gender;
            this.health = health;
            this.preg = preg;
            this.pregStart = pregStart;
            this.descript = descript;
            this.loc = loc;
            this.owner = owner;
            this.pos = pos;
            this.intel = intel;
            this.brawn = brawn;
            this.charisma = charisma;
            this.expMilitary = expMilitary;
            this.expAdmin = expAdmin;
        }

        //Helper for save and load functions. Not strictly required, but nice way to create a dummy.
        public Actor(bool x)
        {
            this.cid = 0;
            this.name = "";
            this.birth = 0;
            this.gender = false;
            this.health = 0;
            this.preg = 0;
            this.pregStart = 0;
            this.descript = "";
            this.loc = 0;
            this.owner = 0;
            this.pos = 0;
            this.intel = 0;
            this.brawn = 0;
            this.charisma = 0;
            this.expMilitary = 0;
            this.expAdmin = 0;
        }

        public void loadPlanet()
        {
            var dbCon = DBConnection.Instance();
            dbCon.DatabaseName = "myDB";
            if (dbCon.IsConnect())
            {
                Console.WriteLine("Loading Actor Data");
                string query = "SELECT cid, name, birth, gender, health, preg, pregStart, descript, loc, owner, pos, intel, brawn, charisma, expMilitary, expAdmin FROM actor"; //Looking for current highest cid.
                var cmd = new MySqlCommand(query, dbCon.Connection);
                var reader = cmd.ExecuteReader();
                Actor actor;
                while (reader.Read())
                {
                    //Reads each actor's info in, row by row.
                    actor = new Actor(reader.GetInt32(0), reader.GetString(1),
                    reader.GetInt32(2), reader.GetBool(3), reader.GetInt32(4),
                    reader.GetInt32(5), reader.GetInt32(6), reader.GetString(7),
                    reader.GetInt32(8), reader.GetInt32(9), reader.GetInt32(10),
                    reader.GetInt32(11), reader.GetInt32(12), reader.GetInt32(13),
                    reader.GetInt32(14), reader.GetInt32(15));
                    Global.actorList.Add(actor);
                    Global.highCID = reader.GetInt32(0);
                }
                Console.WriteLine("Loaded Actors");
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
                Console.WriteLine("Saving Actor Data to Database");
                //Actor
                for (int j = 0; j < Global.planetList.Count(); j++)
                {
                    query = String.Format("INSERT INTO actor (cid, name, birth, gender, health, preg, pregStart, descript, loc, owner, pos, intel, brawn, charisma, expMilitary, expAdmin)" +
                        " VALUES ('{0}', '{1}', '{2}', '{3}', '{4}', '{5}', '{6}', '{7}', '{8}', '{9}', '{10}', '{11}', '{12}', '{13}', '{14}', '{15}') " +
                        "ON DUPLICATE KEY UPDATE " +
                        "name='{1}', " +
                        "birth='{2}', " +
                        "gender='{3}', " +
                        "health='{4}', " +
                        "preg='{5}', " +
                        "pregStart='{6}', " +
                        "descript='{7}', " +
                        "loc='{8}', " +
                        "owner='{9}', " +
                        "pos='{10}', " +
                        "intel='{11}', " +
                        "brawn='{12}', " +
                        "charisma='{13}', " +
                        "expMilitary='{14}', " +
                        "expAdmin='{15}'",
                        Global.actorList[j].cid,
                        Global.actorList[j].name,
                        Global.actorList[j].birth,
                        Global.actorList[j].gender,
                        Global.actorList[j].health,
                        Global.actorList[j].preg,
                        Global.actorList[j].pregStart,
                        Global.actorList[j].descript,
                        Global.actorList[j].loc,
                        Global.actorList[j].owner,
                        Global.actorList[j].pos,
                        Global.actorList[j].intel,
                        Global.actorList[j].brawn,
                        Global.actorList[j].charisma,
                        Global.actorList[j].expMilitary,
                        Global.actorList[j].expAdmin);
                    cmd = new MySqlCommand(query, dbCon.Connection);
                    cmd.ExecuteNonQuery();
                }
                Console.WriteLine("Actor Data Saved.");
                dbCon.Close();
            }
        }
    }
}
