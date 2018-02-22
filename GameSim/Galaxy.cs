using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace GameSim
{
    class Galaxy
    {
        // initial construction stuff, constructor and called-by-constructor
        public Galaxy(int l, int h)
        {
            StatInit(l, h);
            ThreadInit();
            for (int i = 0; i < height; i++)
            {
                for (int j = 0; j < length; j++)
                {
                    if (i == 0 || i == height - 1)
                    {
                        sectorLayout[i, j] = new Sector('-', i, j);
                    }
                    else if (j == 0 || j == length - 1)
                    {
                        sectorLayout[i, j] = new Sector('|', i, j);
                    }
                    else
                    {
                        sectorLayout[i, j] = new Sector(' ', i, j);
                    }
                }
            } //initial decl
            ship = new Player(); // lat, long, docked, direction
            galGen();
        } // constructor, generates map + borders, other default info
        private void StatInit(int l, int h)
        {
            length = l;
            height = h;
            diagDist = Program.Round100(l * h);
            sectorLayout = new Sector[h, l];
            allPlanets = new List<Sector>();
            linkMin = 2;
            linkMax = 5;
            linkTry = 20;
            checkDrop = 2;
        }
        private void ThreadInit()
        {
            var keyThread = new System.Threading.Thread(keyGrab);
            keyThread.Start();
            keyThread.IsBackground = true;
            /*var stringThread = new System.Threading.Thread(stringGrab);
            stringThread.Start();
            stringThread.IsBackground = true;*/
        } // initializes threads
        private void galGen()
        {
            int init = (int)Math.Ceiling((double)length * height / 400);
            int roll = 3 * init;
            int decr = 2;
            //Random r = new Random();
            int a, b;
            for (int count = 0; count < init;)
            {
                b = Program.r.Next(1, length - 1);
                a = Program.r.Next(1, height - 1);
                if (!surrounded(a, b))
                {
                    sectorLayout[a, b] = new Sector('O', a, b);
                    allPlanets.Add(sectorLayout[a, b]); //lat, long
                    count++;
                }
            } // first passthrough of planet gen, always generates [init] number of planets
            for (; ; )
            {
                a = Program.r.Next(0, roll);
                if (a == 0)
                {
                    break;
                }
                b = Program.r.Next(1, length - 1);
                a = Program.r.Next(1, height - 1);
                if (!surrounded(a, b))
                {
                    sectorLayout[a, b] = new Sector('O', a, b);
                    allPlanets.Add(sectorLayout[a, b]); //lat, long
                    roll = roll - decr;
                }
            } // second passthrough of planet gen, 1/[roll] chance of breaking, else makes planet and decreases [roll]
            ship.here = allPlanets[0];
            sectorLayout[ship.here.longitude, ship.here.latitude].displayToken = '@';
            ship.docked = true; //docked
            ship.direction = 0;
            //ship always starts docked at first generated sector
            planetLink();
        } // populates map with planets
        private bool surrounded(int a, int b)
        {
            if (sectorLayout[a, b].displayToken != ' ')
            {
                return true;
            }
            if (sectorLayout[a - 1, b].displayToken != ' ')
            {
                return true;
            }
            if (sectorLayout[a + 1, b].displayToken != ' ')
            {
                return true;
            }
            if (sectorLayout[a, b - 1].displayToken != ' ')
            {
                return true;
            }
            if (sectorLayout[a - 1, b - 1].displayToken != ' ')
            {
                return true;
            }
            if (sectorLayout[a + 1, b - 1].displayToken != ' ')
            {
                return true;
            }
            if (sectorLayout[a, b + 1].displayToken != ' ')
            {
                return true;
            }
            if (sectorLayout[a - 1, b + 1].displayToken != ' ')
            {
                return true;
            }
            if (sectorLayout[a + 1, b + 1].displayToken != ' ')
            {
                return true;
            }
            return false;
        } // checks if potential planet location has any nearby planets
        private void planetLink()
        {
            for (int i = 0; i < allPlanets.Count; i++)
            {
                int j = 0;
                int trys;
                while (allPlanets[i].linkCount < linkMax && (j++ >= linkTry || allPlanets[i].linkCount < linkMin))
                {
                    //tryLink(sectorLayout[allPlanets[i][1], allPlanets[i][0]]);
                    trys = Program.r.Next(0, allPlanets.Count);
                    if (i == trys || allPlanets[trys].linkCount >= linkMax)
                    {
                        continue;
                    }
                    if (Program.r.Next(0, diagDist/checkDrop) > Program.SqDist(allPlanets[i].latitude, allPlanets[trys].latitude, allPlanets[i].longitude, allPlanets[trys].longitude))
                    {
                        makeLink(i, trys);
                    }
                }
            }
        } // makes hyperlanes between planets
        private void makeLink(int first, int second)
        {
            sectorLayout[allPlanets[first].longitude, allPlanets[first].latitude].Links.Add(allPlanets[second]);
            allPlanets[first].linkCount++;
            sectorLayout[allPlanets[second].longitude, allPlanets[second].latitude].Links.Add(allPlanets[first]);
            allPlanets[second].linkCount++;
        } // actually makes the hyperlane

        // output display stuff
        public void printGalaxy()
        {
            Console.Clear();
            int iInit = 0;
            int iTo = 0;
            int jInit = 0;
            int jTo = 0;
            if (height <= 49)
            {
                iInit = 0;
                iTo = height;
            }
            else
            {
                iInit = ship.here.longitude - 24;
                iTo = ship.here.longitude + 24;
                if (iInit < 0)
                {
                    iInit = 0;
                    iTo = 48;
                }
                else if (iTo >= height)
                {
                    iInit = height - 48;
                    iTo = height;
                }
            }
            if (length <= 101)
            {
                jInit = 0;
                jTo = length;
            }
            else
            {
                jInit = ship.here.latitude - 50;
                jTo = ship.here.latitude + 50;
                if (jInit < 0)
                {
                    jInit = 0;
                    jTo = 100;
                }
                else if (jTo >= length)
                {
                    jInit = length - 100;
                    jTo = length;
                }
            }
            for (int j = jInit; j < jTo + 2; j++)
            {
                Console.Write('-');
            }
            Console.WriteLine();
            for (int i = iInit; i < iTo; i++)
            {
                Console.Write('|');
                for (int j = jInit; j < jTo; j++)
                {
                    Console.Write(sectorLayout[i, j].displayToken);
                }
                Console.WriteLine('|');
            }
            for (int j = jInit; j < jTo + 2; j++)
            {
                Console.Write('-');
            }
            Console.WriteLine();
            printHere();
        } // prints map of surrounding galactic map
        public void printSectors()
        {
            for (int i = 0; i < allPlanets.Count(); i++)
            {
                Console.WriteLine("{0} located at ({1}, {2}) (size: {3})", allPlanets[i].sectorType, allPlanets[i].latitude, allPlanets[i].longitude, allPlanets[i].psize);
            }
            Console.WriteLine("{0} planets total", allPlanets.Count());
        } // prints full list of all generated planets (DO NOT USE AT LARGE MAP SIZES)
        public void printHere()
        {
            Console.Write("You are ");
            if (ship.docked)
            {
                Console.Write("orbiting ");
            }
            else
            {
                Console.Write("located at ");
            }
            Console.Write("{0} at ({1}, {2})", ship.here.sectorType, ship.here.latitude, ship.here.longitude);
            if (!ship.docked)
            {
                Console.WriteLine();
                return;
            }
            Console.WriteLine(" [size: {0}]", ship.here.psize);
            ship.here.planetPrint();
            Console.WriteLine();
            for (int i = 0; i < ship.here.linkCount; i++)
            {
                Console.WriteLine("[{0}] Hyperlane to {1} at ({2}, {3})", i + 1, ship.here.Links[i].sectorType, ship.here.Links[i].latitude, ship.here.Links[i].longitude);
            }
        } // prints current location information, including planet map if at a planet

        // gameplay stuff
        public bool play()
        {
            //for ship.direction 0 up, 1 left, 2 down, 3 right, defaults to 0
            string input = userInput.ToLower();
            string[] move = input.Split(' ');
            int dist = 1;
            if (move.Length > 1)
            {
                int.TryParse(move[1], out dist);
            }
            if (move[0][0] == 'l' || move[0][0] == 'w')
            {
                if (ship.here.latitude - dist <= 0)
                {
                    return true;
                }
                ship.direction = 1;
            }
            else if (move[0][0] == 'r' || move[0][0] == 'e')
            {
                if (ship.here.latitude + dist >= length)
                {
                    return true;
                }
                ship.direction = 3;
            }
            else if (move[0][0] == 'u' || move[0][0] == 'n')
            {
                if (ship.here.longitude - dist <= 0)
                {
                    return true;
                }
                ship.direction = 0;
            }
            else if (move[0][0] == 'd' || move[0][0] == 's')
            {
                if (ship.here.longitude + dist >= height)
                {
                    return true;
                }
                ship.direction = 2;
            }
            else
            {
                return true;
            }
            moving(ship.direction, dist);
            return true;
        } // gameplay wrapper function, currently only handles motion input
        public bool play(int a)
        {
            if (key.Key.ToString() == "UpArrow")
            {
                if (ship.here.longitude == 0)
                {
                    return true;
                }
                ship.direction = 0;
            }
            else if (key.Key.ToString() == "LeftArrow")
            {
                if (ship.here.latitude == 0)
                {
                    return true;
                }
                ship.direction = 1;
            }
            else if (key.Key.ToString() == "DownArrow")
            {
                if (ship.here.longitude == height - 1)
                {
                    return true;
                }
                ship.direction = 2;
            }
            else if (key.Key.ToString() == "RightArrow")
            {
                if (ship.here.latitude == length - 1)
                {
                    return true;
                }
                ship.direction = 3;
            }
            else
            {
                return true;
            }
            key = default(ConsoleKeyInfo);
            moving(ship.direction, 1);
            return true;
        } // handles arrow key presses instead of commands
        public bool play(double a)
        {
            if(key.KeyChar - '0' <= ship.here.linkCount && key.KeyChar - '0' > 0)
            {
                ship.here.restore();
                ship.here = ship.here.Links[key.KeyChar - '1'];
                ship.here.displayToken = '@';
                printGalaxy();
                key = default(ConsoleKeyInfo);
                return true;
            }
            else if (key.Key.ToString() == "UpArrow")
            {
                if (ship.here.longitude == 0)
                {
                    return true;
                }
                ship.direction = 0;
            }
            else if (key.Key.ToString() == "LeftArrow")
            {
                if (ship.here.latitude == 0)
                {
                    return true;
                }
                ship.direction = 1;
            }
            else if (key.Key.ToString() == "DownArrow")
            {
                if (ship.here.longitude == height - 1)
                {
                    return true;
                }
                ship.direction = 2;
            }
            else if (key.Key.ToString() == "RightArrow")
            {
                if (ship.here.latitude == length - 1)
                {
                    return true;
                }
                ship.direction = 3;
            }
            else
            {
                return true;
            }
            key = default(ConsoleKeyInfo);
            moving(ship.direction, 1);
            return true;
        } //handles hyperlane movement and arrow keys
        
        private void moving(int dir, int dist)
        {
            //for ship.direction 0 up, 1 left, 2 down, 3 right, defaults to 0
            ship.here.restore();
            if (dir == 0)
            {
                ship.here = sectorLayout[ship.here.longitude - dist, ship.here.latitude];
                ship.here.displayToken = '^';
            }
            else if (dir == 1)
            {
                ship.here = sectorLayout[ship.here.longitude, ship.here.latitude - dist];
                ship.here.displayToken = '<';
            }
            else if (dir == 2)
            {
                ship.here = sectorLayout[ship.here.longitude + dist, ship.here.latitude];
                ship.here.displayToken = 'v';
            }
            else if (dir == 3)
            {
                ship.here = sectorLayout[ship.here.longitude, ship.here.latitude + dist];
                ship.here.displayToken = '>';
            }
            if (ship.here.defaultToken != ' ' && ship.here.defaultToken != '|' && ship.here.defaultToken != '-')
            {
                ship.here.displayToken = '@';
                ship.docked = true;
            }
            else
            {
                ship.docked = false;
            }
            printGalaxy();
        } // handles basic movement. might rewrite to be recursive later

        //threading stuff, mostly user input
        private void keyGrab()
        {
            for (; ; )
            {
                key = Console.ReadKey(true);
                //System.Threading.Thread.Sleep(40);
                //key = default(ConsoleKeyInfo);
            }
        }
        private void stringGrab()
        {
            for (; ; )
            {
                userInput = Console.ReadLine();
                System.Threading.Thread.Sleep(25);
                userInput = default(string);
            }
        }

        private int length, height, diagDist, checkDrop;
        private int linkMin, linkMax, linkTry;
        private ConsoleKeyInfo key;
        private string userInput;
        private Sector[,] sectorLayout; // list of all sectors; long, lat
        public List<Sector> allPlanets; // list of all planets
        public Player ship;
    }
}
