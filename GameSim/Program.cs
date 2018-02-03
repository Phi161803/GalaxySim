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
            Galaxy thisGal = new Galaxy(120, 50);
            thisGal.populateGalaxy(16, 40, 2);
            thisGal.printGalaxy();
            thisGal.printSectors();
            while (thisGal.motion()) ;
        }
    }
}
