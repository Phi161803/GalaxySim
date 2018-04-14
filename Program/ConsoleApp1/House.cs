using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using MySql.Data.MySqlClient;

namespace ShadowNova
{
    class House
    {
        public int hid;
        public string name;
        public int home; //hid
        public string quote;
        public List<house_relation> houseRelation = new List<house_relation>();
        //public List<int> houseChar = new List<int>();
        //public List<int> houseUnit = new List<int>();
        //public List<int> housePlanet = new List<int>();
        //public List<int> houseSetting = new List<int>();

        //Default Constructor Generates Random Values
        public House()
        {
            string[] option;

            hid = ++Global.highHID;
            name = "House TestNUM" + hid;
            home = Program.r.Next(2, Global.highPID);
            quote = "Unoriginal quote Number" + hid;

            for (int i = Program.r.Next(1, Global.highHID); i > 0; i--)
            {
                bool l = false;
                int j = Program.r.Next(1, Global.highHID);

                for(int k = 0; k < houseRelation.Count(); k++)
                {
                    if (houseRelation[k].hid == j)
                    { l = true;  break;}
                }
                if(l == false)
                {
                    int b = Program.r.Next(1, 3);
                    house_relation a = new house_relation(j, b);
                    houseRelation.Add(a);
                }
            }
        }

        public House(int hid, string name, int home, string quote)
        {
            this.hid = hid;
            this.name = name;
            this.home = home;
            this.quote = quote;
        }

        public House(int hid, string name, int home, string quote, List<house_relation> houseRelation)
        {
            this.hid = hid;
            this.name = name;
            this.home = home;
            this.quote = quote;
            this.houseRelation = houseRelation;
        }

        public void loadHouse()
        {
            var dbCon = DBConnection.Instance();
            dbCon.DatabaseName = "myDB";
            if (dbCon.IsConnect())
            {
                Console.WriteLine("Loading House Data");
                string query = "SELECT hid, name, home, quote FROM house"; //Looking for current highest hid.
                var cmd = new MySqlCommand(query, dbCon.Connection);
                var reader = cmd.ExecuteReader();
                House house;
                while (reader.Read())
                {
                    //Reads each planet's info in, row by row.
                    house = new House(reader.GetInt32(0), reader.GetString(1),
                    reader.GetInt32(2), reader.GetString(3));
                    Global.houseList.Add(house);
                    Global.highHID = reader.GetInt32(0);
                }
                
                reader.Close();
                query = "SELECT hid, hid2, relation FROM house_relation"; //Looking for current highest hid.
                cmd = new MySqlCommand(query, dbCon.Connection);
                reader = cmd.ExecuteReader();
                house_relation hr;
                while (reader.Read())
                {
                    //Reads each houses's info in, row by row.
                    hr = new house_relation(reader.GetInt32(1), reader.GetInt32(2));
                    Global.houseList[reader.GetInt32(0)].houseRelation.Add(hr);
                    Global.highPID = reader.GetInt32(0);
                }

                Console.WriteLine("Loaded Houses");
                reader.Close();
                dbCon.Close();
            }
        }


        public void saveHouse()
        {
            var dbCon = DBConnection.Instance();
            dbCon.DatabaseName = "myDB";
            string query = "";
            var cmd = new MySqlCommand(query, dbCon.Connection);

            if (dbCon.IsConnect())
            {
                Console.WriteLine("Saving House Data to Database");
                for (int j = 0; j < Global.houseList.Count(); j++)
                {
                    query = String.Format("INSERT INTO house (hid, name, home, quote)" +
                        " VALUES ('{0}', '{1}', '{2}', '{3}') " +
                        "ON DUPLICATE KEY UPDATE name='{1}', home='{2}', quote='{3}'",
                        Global.houseList[j].hid,
                        Global.houseList[j].name,
                        Global.houseList[j].home,
                        Global.houseList[j].quote);
                    //Console.WriteLine(query);
                    cmd = new MySqlCommand(query, dbCon.Connection);
                    cmd.ExecuteNonQuery();

                    for (int k = 0; k < Global.houseList[k].houseRelation.Count(); k++)
                    {
                        query = String.Format("INSERT INTO house_relation (hid, hid2, relation)" +
                            " VALUES ('{0}', '{1}', '{2}') " +
                            "ON DUPLICATE KEY UPDATE hid='{1}', hid2='{2}', relation='{3}'",
                            j,
                            Global.houseList[j].houseRelation[k].hid,
                            Global.houseList[j].houseRelation[k].relation);
                        //Console.WriteLine(query);
                        cmd = new MySqlCommand(query, dbCon.Connection);
                        cmd.ExecuteNonQuery();
                    }

                }
                dbCon.Close();
            }
        }

    }

    public class house_relation
    {
        public int hid;
        public int relation;

        public house_relation(int hid, int relation)
        {
            this.hid = hid;
            this.relation = relation;
        }
    }
}
