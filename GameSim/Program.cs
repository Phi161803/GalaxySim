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
            thisGal.populateGalaxy(16, 40, 2);
            thisGal.printGalaxy();
            //thisGal.printSectors();
            Console.WriteLine("{0} planets total", thisGal.allSectors.Count());
            while (thisGal.motion()) ;
        }

        static Random r = new Random();
    }
}
