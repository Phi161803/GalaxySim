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
        public static int galaxySize = 50; //More than 250 is bad for the frontend right now.
        public static int highPID = 0;
        public static int highHID = 0;
        public static int highHold = 0;
        public static int highSLID = 0;
        public static int highCID = 0;
        public static List<Planet> planetList = new List<Planet>();
        public static List<House> houseList = new List<House>();
        public static List<Holding> holdingList = new List<Holding>();
        public static List<Starlane> laneList = new List<Starlane>();
        public static List<Actor> actorList = new List<Actor>();
        public static Planet[] pla = new Planet[10000];
    }



    class Program //Main Class
	{
		static void Main(string[] rgs)
		{
            Load();

            var dbCon = DBConnection.Instance();
            dbCon.DatabaseName = "myDB";
            int timeCheck = 5000; //Time between checks, 5 seconds
            int timeCount = 0; //Time that has occured since last tick
            int ticktime = 250 * 60;//Time to trigger next Tick, minute * number of minutes. Should be 60000 for 1 hour
            int triggerTick = 0;
            int shutdown = 0;
            int createGal = 0;



            Heartbeat beat = new Heartbeat();
            while(true)
            {
                if (dbCon.IsConnect())
                {
                    Console.WriteLine("Checking Status. timeCount: " + timeCount + " Out of timetick: " + ticktime);
                    string query = "SELECT manualTick, shutdown, createGal FROM setting"; //Looking for current highest pid.
                    var cmd = new MySqlCommand(query, dbCon.Connection);
                    var reader = cmd.ExecuteReader();

                    while (reader.Read())
                    {
                        triggerTick = reader.GetInt32(0);
                        shutdown = reader.GetInt32(1);
                        createGal = reader.GetInt32(2);
                    }
                    reader.Close();

                    if (triggerTick == 1 || timeCount >= ticktime)
                    {
                        if (triggerTick == 1) Console.WriteLine("Manual Tick Triggered");
                        else Console.WriteLine("Tick Timer Trigger");
                        beat.beat();
                        timeCount = 0;
                    }

                    if (createGal == 1)
                    {
                        Console.WriteLine("Galaxy Creation Triggered");
                        Creation();
                        Save();
                        break;
                    }

                    if (shutdown == 1)
                    {
                        Console.WriteLine("Shutdown Triggered");
                        break;
                    }

                }
                System.Threading.Thread.Sleep(timeCheck); //Waits 5 seconds
                timeCount += timeCheck;
            }
            //dbCon.Close();
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

            Actor act = new Actor(false);
            act.loadActor();
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
            Actor act = new Actor(false);
            act.saveActor();
        }

        //Creates a new galaxy with random spawns, good for testing.
        public static void Creation()
        {
            //Populating Galaxy with Random Planets
            int planets = Global.galaxySize * Global.galaxySize / 100;
            Planet newPlanet;
            for (int i = Global.highPID; i < planets; i++)
            {
                newPlanet = new Planet();
                Global.planetList.Add(newPlanet);
            }
            Console.WriteLine("Created Planets.");

            //Populating Galaxy with Random Houses
            House nh;
            for (int i = Global.highHID; i < 100; i++)
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

            for (int i = Global.highHold; i < 500; i++)
            {
                nho = new Holding();
                Global.holdingList.Add(nho);
            }
            Console.WriteLine("Created Holdings.");

            //Starlane lane = new Starlane(4);
            // Global.laneList.Add(lane);
            //Console.WriteLine("highSLID: " + Global.highSLID);


            for (int i = 1; i <= Global.highPID; i++)
            {
                try
                {
                    Starlane lane = new Starlane(i);
                    Global.laneList.Add(lane);
                }
                catch { break; }
            }



        }


    }
}




