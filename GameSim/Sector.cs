using System;
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
        public Sector(char x)
        {
            displayToken = x;
            if(x == ' ')
            {
                sectorType = "empty space";
            }
            else if(x == '|' || x == '-')
            {
                sectorType = "the edge of space";
            }
            else
            {
                sectorType = "a sector";
            }
            defaultToken = displayToken;
        }
        public void restore()
        {
            displayToken = defaultToken;
        }

        public char displayToken;
        public char defaultToken { get; private set; }
        public string sectorType { get; private set; }
        public int size;
        private char[,] map;
        //public int[] location { get; private set; }
    }
}
