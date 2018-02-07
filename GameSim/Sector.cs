﻿using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace GameSim
{
    class Sector
    {
        public Sector()
        {
            displayToken = ' ';
            sectorType = "empty space";
            defaultToken = displayToken;
        }
        public Sector(char x, Random r)
        {
            displayToken = x;
            if(x == ' ')
            {
                sectorType = "empty space";
                psize = 0;
            }
            else if(x == '|' || x == '-')
            {
                sectorType = "the edge of space";
                psize = 0;
            }
            else
            {
                psize = sizeSet(20, 6, r);
                if(psize > 15)
                {
                    sectorType = "a large planet";
                }
                else if(psize <= 5)
                {
                    sectorType = "a dwarf planet";
                }
                else if(psize <= 10)
                {
                    sectorType = "a small planet";
                }
                else
                {
                    sectorType = "a planet";
                }
            }
            defaultToken = displayToken;
        }
        public void restore()
        {
            displayToken = defaultToken;
        }

        private int sizeSet(int rolls, int chanceoften, Random r)
        {
            //Random r = new Random();
            int size = 0;
            for(int i = 0; i < rolls; i++)
            {
                if(r.Next(10) < chanceoften)
                {
                    size++;
                }
            }
            if(size < 4)
            {
                return 4;
            }
            return size;
        }

        public char displayToken;
        public char defaultToken { get; private set; }
        public string sectorType { get; private set; }
        public int psize { get; private set; }
        private char[,] map;
        //private Random r = new Random();
        //public int[] location { get; private set; }
    }
}
