using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace GameSim
{
    class Lane
    {
        public Lane(Sector a, Sector b)
        {
            end1 = a;
            end2 = b;
            time = (int)Math.Ceiling(Math.Ceiling(Program.SqDist(a, b)) / 5);
        }

        public Sector end1 { get; private set; }
        public Sector end2 { get; private set; }
        public int time { get; private set; }
        public int decay;
    }
}
