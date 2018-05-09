﻿using System;
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
        public int owner;
        public int commander;
        public bool defMob;
        public bool type;
        public int points;
        public int exp;
        public bool active;
        public int camp;

        //Default Constructor Generates Random Values 
        public MilitaryUnit()
        {
            mid = ++Global.highMID;
            owner = Program.r.Next(1, Global.highHID);
            commander = Program.r.Next(1, Global.highCID);
            defMob = false;
            type = false;
            points = Program.r.Next(0, 999);
            exp = Program.r.Next(0, 999);
            active = false;
            camp = 0;
        }

        //If you have a specific actor that you want created, lets you feed everything in.  
        public MilitaryUnit(int mid, int owner, int commander, bool defMob, bool type, int points, int exp, bool active, int camp)
        {
            this.mid = mid;
            this.owner = owner;
            this.commander = commander;
            this.defMob = defMob;
            this.type = type;
            this.points = points;
            this.exp = exp;
            this.active = active;
            this.camp = camp;
        }

        //Helper for save and load functions. Not strictly required, but nice way to create a dummy.
        public MilitaryUnit(bool x)
        {
            mid = 0;
            owner = 0;
            commander = 0;
            defMob = false;
            type = false;
            points = 0;
            exp = 0;
            active = false;
            camp = 0;
        }

        public void loadMilitaryUnit()
        {
            var dbCon = DBConnection.Instance();
            dbCon.DatabaseName = "myDB";
            if (dbCon.IsConnect())
            {
                Console.WriteLine("Loading MilitaryUnit Data");
                string query = "SELECT mid, owner, commander, defMob, type, points, exp, active, camp FROM militaryunit"; //Looking for current highest cid.
                var cmd = new MySqlCommand(query, dbCon.Connection);
                var reader = cmd.ExecuteReader();
                MilitaryUnit militaryUnit;
                while (reader.Read())
                {
                    //Reads each militaryunit's info in, row by row.
                    militaryUnit = new MilitaryUnit(reader.GetInt32(0), reader.GetInt32(1),
                    reader.GetInt32(2), reader.GetBoolean(3), reader.GetBoolean(4),
                    reader.GetInt32(5), reader.GetInt32(6), reader.GetBoolean(7),
                    reader.GetInt32(8));
                    Global.unitList.Add(militaryUnit);
                    Global.highCID = reader.GetInt32(0);
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
                    query = String.Format("INSERT INTO militaryUnit mid, owner, commander, defMob, type, points, exp, active, camp)" +
                        " VALUES ('{0}', '{1}', '{2}', '{3}', '{4}', '{5}', '{6}', '{7}', '{8}') " +
                        "ON DUPLICATE KEY UPDATE " +
                        "owner='{1}', " +
                        "commander='{2}', " +
                        "defMob='{3}', " +
                        "type='{4}', " +
                        "points='{5}', " +
                        "exp='{6}', " +
                        "active='{7}', " +
                        "camp='{9}'",
                        Global.unitList[j].mid,
                        Global.unitList[j].owner,
                        Global.unitList[j].commander,
                        Global.unitList[j].defMob,
                        Global.unitList[j].type,
                        Global.unitList[j].points,
                        Global.unitList[j].exp,
                        Global.unitList[j].active,
                        Global.unitList[j].camp);
                    cmd = new MySqlCommand(query, dbCon.Connection);
                    cmd.ExecuteNonQuery();
                }
                Console.WriteLine("MilitaryUnit Data Saved.");
                dbCon.Close();
            }
        }
    }
}