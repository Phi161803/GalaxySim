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
        public static int galaxySize = 250; //More than 250 is bad for the frontend right now. It will be fixed.
        public static int highPID = 0;
        public static int highHID = 0;
        public static int highHold = 0;
        public static int highSLID = 0;
        public static List<Planet> planetList = new List<Planet>();
        public static List<House> houseList = new List<House>();
        public static List<Holding> holdingList = new List<Holding>();
        public static List<Starlane> laneList = new List<Starlane>();
        public static Planet[] pla = new Planet[10000];
    }



    class Program //Main Class
	{
		static void Main(string[] rgs)
		{
            Load();
            Creation();
            Save();   
		}

        //Helpers
        static public Random r = new Random();

        //Load function for mass refreshing of data from database.
        //Add code to drop arrays before regrabbing data later.
        public static void Load()
        {
            Planet planet = new Planet(false);
            Global.planetList.Add(planet);
            planet.loadPlanet();

            House house = new House(false);
            Global.houseList.Add(house);
            house.loadHouse();

            Holding holding = new Holding(false);
            holding.loadHolding();

            Starlane lane = new Starlane(false);
            lane.loadStarlane();
        }

        //Save function
        public static void Save()
        {
            Planet planet = new Planet(false);
            planet.savePlanet();
            House house = new House(false);
            house.saveHouse();
            Holding holding = new Holding(false);
            holding.saveHolding();
            Starlane lane = new Starlane(false);
            lane.saveStarlane();
        }

        //Creates a new galaxy with random spawns, good for testing.
        public static void Creation()
        {
            //Populating Galaxy with Random Planets
            int planets = Global.galaxySize * Global.galaxySize / 400;
            Planet newPlanet;
            for (int i = Global.highPID; i < planets; i++)
            {
                newPlanet = new Planet();
                Global.planetList.Add(newPlanet);
            }
            Console.WriteLine("Created Planets.");

            //Populating Galaxy with Random Houses
            House nh;
            for (int i = Global.highHID; i < 1000; i++)
            {
                nh = new House();
                Global.houseList.Add(nh);
            }
            Console.WriteLine("Created Houses.");

            //Populating Galaxy with Random Holdings of Houses
            Holding nho;
            //Adds a holding to every planet, more or less.
            for (int i = Global.highHold; i < Global.highPID; i++)
            {
                nho = new Holding();
                nho.pid = i;
                Global.holdingList.Add(nho);
            }

            for (int i = Global.highHold; i < 1000; i++)
            {
                nho = new Holding();
                Global.holdingList.Add(nho);
            }
            Console.WriteLine("Created Holdings.");

            //Lane Creation, always makes two.
            Starlane lane;
            for (int i = 0; i < Global.highPID; i++)
            {
                lane = new Starlane(i);
                Global.laneList.Add(lane);
                lane = new Starlane(i);
                Global.laneList.Add(lane);
            }

            for (int i = Global.highPID; i < 1; i++)
            {
               // lane = new Starlane();
               // Global.laneList.Add(lane);
            }
            Console.WriteLine("Created Starlanes.");


        }


    }
}




