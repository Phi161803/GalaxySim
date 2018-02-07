using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace GameSim
{
    class Galaxy
    {
        public Galaxy(int l, int h)
        {
            length = l;
            height = h;
            sectorLayout = new Sector[h, l];
            allSectors = new List<int[]>();
            for (int i = 0; i < height; i++)
            {
                for (int j = 0; j < length; j++)
                {
                    if (i == 0 || i == height - 1)
                    {
                        sectorLayout[i, j] = new Sector('-', r);
                    }
                    else if(j == 0 || j == length - 1)
                    {
                        sectorLayout[i, j] = new Sector('|', r);
                    } else
                    {
                        sectorLayout[i, j] = new Sector(' ', r);
                    }
                }
            } //initial decl
            ship = new int[4]; // lat, long, docked, direction
        }
        public void populateGalaxy()
        {
            //galGen(15, 35, 1);
            galGen();
        }
        public void populateGalaxy(int init, int roll, int decr)
        {
            //galGen(init, roll, decr);
            galGen();
        }
        private void galGen(int init, int roll, int decr)
        {
            //Random r = new Random();
            int a, b;
            for (int count = 0; count < init;)
            {
                b = r.Next(1, length - 1);
                a = r.Next(1, height - 1);
                if (!surrounded(a, b))
                {
                    sectorLayout[a, b] = new Sector('O', r);
                    allSectors.Add(new int[2] { b, a }); //lat, long
                    count++;
                }
            }
            for(; ; )
            {
                a = r.Next(0, roll);
                if(a == 0)
                {
                    break;
                }
                b = r.Next(1, length - 1);
                a = r.Next(1, height - 1);
                if (!surrounded(a, b))
                {
                    sectorLayout[a, b] = new Sector('O', r);
                    allSectors.Add(new int[2] { b, a }); //lat, long
                    roll = roll - decr;
                }
            }
            ship[0] = allSectors[0][0]; //lat
            ship[1] = allSectors[0][1]; //long
            sectorLayout[ship[1], ship[0]].displayToken = '@';
            ship[2] = 1; //docked
            ship[3] = 0;
            //ship always starts docked at first generated sector
        }
        private void galGen()
        {
            int init = (int)Math.Ceiling((double)length * height / 400);
            int roll = 3*init;
            int decr = 2;
            //Random r = new Random();
            int a, b;
            for (int count = 0; count < init;)
            {
                b = r.Next(1, length - 1);
                a = r.Next(1, height - 1);
                if (!surrounded(a, b))
                {
                    sectorLayout[a, b] = new Sector('O', r);
                    allSectors.Add(new int[2] { b, a }); //lat, long
                    count++;
                }
            }
            for (; ; )
            {
                a = r.Next(0, roll);
                if (a == 0)
                {
                    break;
                }
                b = r.Next(1, length - 1);
                a = r.Next(1, height - 1);
                if (!surrounded(a, b))
                {
                    sectorLayout[a, b] = new Sector('O', r);
                    allSectors.Add(new int[2] { b, a }); //lat, long
                    roll = roll - decr;
                }
            }
            ship[0] = allSectors[0][0]; //lat
            ship[1] = allSectors[0][1]; //long
            sectorLayout[ship[1], ship[0]].displayToken = '@';
            ship[2] = 1; //docked
            ship[3] = 0;
            //ship always starts docked at first generated sector
        }

        private bool surrounded(int a, int b)
        {
            if (sectorLayout[a, b].displayToken != ' ')
            {
                return true;
            }
            if (sectorLayout[a-1, b].displayToken != ' ')
            {
                return true;
            }
            if (sectorLayout[a+1, b].displayToken != ' ')
            {
                return true;
            }
            if (sectorLayout[a, b-1].displayToken != ' ')
            {
                return true;
            }
            if (sectorLayout[a-1, b-1].displayToken != ' ')
            {
                return true;
            }
            if (sectorLayout[a+1, b-1].displayToken != ' ')
            {
                return true;
            }
            if (sectorLayout[a, b+1].displayToken != ' ')
            {
                return true;
            }
            if (sectorLayout[a-1, b+1].displayToken != ' ')
            {
                return true;
            }
            if (sectorLayout[a+1, b+1].displayToken != ' ')
            {
                return true;
            }
            return false;
        }

        public void printGalaxy()
        {
            int iInit = 0;
            int iTo = 0;
            int jInit = 0;
            int jTo = 0;
            if(height <= 49)
            {
                iInit = 0;
                iTo = height;
            }
            else
            {
                iInit = ship[1] - 24;
                iTo = ship[1] + 24;
                if(iInit < 0)
                {
                    iInit = 0;
                    iTo = 48;
                }
                else if(iTo >= height)
                {
                    iInit = height - 49;
                    iTo = height - 1;
                }
            }
            if (length <= 101)
            {
                jInit = 0;
                jTo = length;
            }
            else
            {
                jInit = ship[0] - 50;
                jTo = ship[0] + 50;
                if (jInit < 0)
                {
                    jInit = 0;
                    jTo = 100;
                }
                else if (jTo >= length)
                {
                    jInit = length - 101;
                    jTo = length - 1;
                }
            }
            for(int j = jInit; j < jTo+2; j++){
                Console.Write('-');
            }
            Console.WriteLine();
            for (int i = iInit; i < iTo; i++)
            {
                Console.Write('|');
                for (int j = jInit; j < jTo; j++)
                {
                    Console.Write(sectorLayout[i,j].displayToken);
                }
                Console.WriteLine('|');
            }
            for (int j = jInit; j < jTo+2; j++)
            {
                Console.Write('-');
            }
            Console.Write("\nYou are ");
            if(ship[2] == 1)
            {
                Console.Write("orbiting ");
            }
            else
            {
                Console.Write("located at ");
            }
            Console.WriteLine("{0} at ({1}, {2})", sectorLayout[ship[1], ship[0]].sectorType, ship[0], ship[1]);
        }
        public void printSectors()
        {
            for(int i = 0; i < allSectors.Count(); i++)
            {
                Console.WriteLine("{0} located at ({1}, {2}) (size: {3})", sectorLayout[allSectors[i][1], allSectors[i][0]].sectorType, allSectors[i][0], allSectors[i][1], sectorLayout[allSectors[i][1], allSectors[i][0]].psize);
            }
            Console.WriteLine("{0} planets total", allSectors.Count());
        }

        public bool motion()
        {
            //for ship[3] 0 up, 1 left, 2 down, 3 right, defaults to 0
            string input = Console.ReadLine().ToLower();
            string[] move = input.Split(' ');
            int dist = 1;
            if (move.Length > 1) {
                int.TryParse(move[1], out dist);
            }
            if (move[0][0] == 'l' || move[0][0] == 'w')
            {
                if(ship[0] - dist <= 0)
                {
                    return true;
                }
                ship[3] = 1;
            }
            else if (move[0][0] == 'r' || move[0][0] == 'e')
            {
                if (ship[0] + dist >= length)
                {
                    return true;
                }
                ship[3] = 3;
            }
            else if(move[0][0] == 'u' || move[0][0] == 'n')
            {
                if (ship[1] - dist <= 0)
                {
                    return true;
                }
                ship[3] = 0;
            }
            else if (move[0][0] == 'd' || move[0][0] == 's')
            {
                if (ship[1] + dist >= height)
                {
                    return true;
                }
                ship[3] = 2;
            }
            else
            {
                return true;
            }
            moving(ship[3], dist);
            return true;
        }
        private void moving(int dir, int dist)
        {
            //for ship[3] 0 up, 1 left, 2 down, 3 right, defaults to 0
            sectorLayout[ship[1], ship[0]].restore();
            if(dir == 0)
            {
                ship[1] = ship[1] - dist;
                sectorLayout[ship[1], ship[0]].displayToken = '^';
            }
            else if (dir == 1)
            {
                ship[0] = ship[0] - dist;
                sectorLayout[ship[1], ship[0]].displayToken = '<';
            }
            else if (dir == 2)
            {
                ship[1] = ship[1] + dist;
                sectorLayout[ship[1], ship[0]].displayToken = 'v';
            }
            else if (dir == 3)
            {
                ship[0] = ship[0] + dist;
                sectorLayout[ship[1], ship[0]].displayToken = '>';
            }
            if (sectorLayout[ship[1], ship[0]].defaultToken != ' ' && sectorLayout[ship[1], ship[0]].defaultToken != '|' && sectorLayout[ship[1], ship[0]].defaultToken != '-')
            {
                sectorLayout[ship[1], ship[0]].displayToken = '@';
                ship[2] = 1;
            }
            else
            {
                ship[2] = 0;
            }
            printGalaxy();
        }

        private int length;
        private int height;
        private Sector[,] sectorLayout;
        public List<int[]> allSectors;
        public int[] ship; // lat, long, docked, direction
        private Random r = new Random();
    }
}
