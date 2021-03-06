﻿using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace GameSim
{
    class Sector
    {
        // initial construction stuff; constructor and called-by-constructor
        public Sector()
        {
            displayToken = ' ';
            sectorType = "empty space";
            defaultToken = displayToken;
        } // default constructor, sets sector to empty space
        public Sector(char x, int a, int b)
        {
            longitude = a;
            latitude = b;
            displayToken = x;
            if(x == '|' || x == '-')
            {
                psize = 0;
                sectorType = "the edge of space";
            }
            else
            {
                psize = sizeSet(20, 5);
                setType();
                planetMap();
            }
            defaultToken = displayToken;
        } //sets sector based on input char
        public void setType()
        {
            Links = new List<Lane>();
            if (displayToken == ' ')
            {
                sectorType = "empty space";
                psize = 0;
            }
            else if (psize == 0)
            {
                sectorType = "the edge of space";
                psize = 0;
            }
            else if (psize > 15)
            {
                sectorType = "a large planet";
            }
            else if (psize <= 5)
            {
                sectorType = "a dwarf planet";
                displayToken = defaultToken = '.';
            }
            else if (psize <= 10)
            {
                sectorType = "a small planet";
                displayToken = defaultToken = 'o';
            }
            else
            {
                sectorType = "a planet";
                displayToken = defaultToken = '0';
            }
        } // sets the name of the type of sector, display purposes
        private int sizeSet(int rolls, int chanceoften)
        {
            int size = 0;
            for(int i = 0; i < rolls; i++)
            {
                if(Program.r.Next(10) < chanceoften)
                {
                    size++;
                }
            }
            if(size < 4)
            {
                return 4;
            }
            return size;
        } // randomly sets size of planet, typical size is 2*chanceoften
        private void planetMap()
        {
            map = new char[psize + 2, (2 * psize) + 2];
            for(int i = 0; i < psize + 2; i++)
            {
                for(int j = 0; j < (2 * psize) + 2; j++)
                {
                    if(i == 0 || i == psize + 1)
                    {
                        map[i, j] = '-';
                    }
                    else if (j == 0 || j == (2 * psize) + 1)
                    {
                        map[i, j] = '|';
                    }
                    else
                    {
                        map[i, j] = ' ';
                    }
                }
            }
        } // generates map of the planet if planet exists

        // used in gameplay
        public void planetPrint()
        {
            if(psize == 0)
            {
                return;
            }
            for (int i = 0; i < psize + 2; i++)
            {
                for (int j = 0; j < (2 * psize) + 2; j++)
                {
                    Console.Write(map[i, j]);
                }
                Console.WriteLine();
            }
        } // prints the map of the planet
        public void restore()
        {
            displayToken = defaultToken;
        } // used when ship moves away, restores display token to value of (permanent) default token

        public char displayToken;
        public char defaultToken { get; private set; }
        public string sectorType { get; private set; }
        public int psize { get; private set; }
        private char[,] map;
        public List<Lane> Links;
        public int linkCount;
        public int longitude, latitude;
        //public int[] location { get; private set; }
    }
}
