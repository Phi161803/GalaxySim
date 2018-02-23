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
            Galaxy thisGal = new Galaxy(1000, 1000); // length, height of galaxy
            thisGal.printGalaxy();
            //thisGal.printSectors(); // DO NOT USE AT HIGH GALAXY SIZES
            Console.WriteLine("{0} planets total", thisGal.allPlanets.Count()); // used for debug/testing
            
            while (thisGal.play(4.0)) ; // loops game
        }
        static public Random r = new Random();

        static public int RoundTo(int inp, int by)
        {
            inp = (int)Math.Ceiling((double)inp / by);
            inp = inp * by;
            return inp;
        }
        static public double SqDist(int l1, int l2, int h1, int h2)
        {
            int i = (l2 - l1) * (l2 - l1) + (h2 - h1) * (h2 - h1);
            double d = Math.Sqrt(i);
            return d;
        }
        static public double SqDist(Sector a, Sector b)
        {
            int i = (a.latitude - b.latitude) * (a.latitude - b.latitude) + (a.longitude - b.longitude) * (a.longitude - b.longitude);
            double d = Math.Sqrt(i);
            return d;
        }
    }
}
