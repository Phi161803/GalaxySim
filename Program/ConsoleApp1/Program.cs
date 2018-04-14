using MySql.Data.MySqlClient;
using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Text;
using System.Threading.Tasks;


namespace ShadowNova
{
    //Global Values
    static class Global
    {
        public static int galaxySize = 50;
        public static int highPID = 0;
        public static int highHID = 0;
        public static List<Planet> planetList = new List<Planet>();
        public static List<House> houseList = new List<House>();
    }



    class Program //Main Class
	{
		static void Main(string[] args)
		{
            Load();
            Planet newPlanet;
            for (int i = Global.highPID; i < Global.galaxySize * Global.galaxySize / 100; i++) //Global.galaxySize*Global.galaxySize/400 Use later
            {
                newPlanet = new Planet();
                Global.planetList.Add(newPlanet);
            }

            House nh;
            for (int i = Global.highHID; i < 20; i++) //Some number for Testing.
            {
                nh = new House();
                Global.houseList.Add(nh);
            }
            Save();
              
		}

        //Helper
        static public Random r = new Random();

        //Load function for mass refreshing of data from database.
        //Add code to drop arrays before regrabbing data later.
        public static void Load()
        {
            Planet planet = new Planet();
            planet.loadPlanet();
            House house = new House();
            house.loadHouse();
        }

        public static void Save()
        {
            Planet planet = new Planet();
            planet.savePlanet();
            House house = new House();
            house.saveHouse();
        }


    }
}




