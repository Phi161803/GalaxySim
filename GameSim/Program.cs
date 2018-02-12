﻿using System;
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
            Console.WriteLine("{0} planets total", thisGal.allSectors.Count()); // used for debug/testing
            
            while (thisGal.play(4)) ; // loops game
        }
        static public Random r = new Random();
    }
}
