using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace GameSim
{
    class Program
    {
        static void Main(string[] args)
        {
            Galaxy thisGal = new Galaxy(1000, 1000);
            thisGal.printGalaxy();
            //thisGal.printSectors();
            Console.WriteLine("{0} planets total", thisGal.allSectors.Count());
            while (thisGal.motion()) ;
        }

        static public Random r = new Random();
    }
}
