using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace ShadowNova
{
    class Heartbeat
    {

    public Heartbeat()
        {

        }


    public void beat()
        {
            for (int i = 0; i < Global.highPID; i++)
            {
                Global.planetList[i].totalPop += Global.planetList[i].popGrowth;
                Global.planetList[i].genLabour += Global.planetList[i].popGrowth  / 3;
                Global.planetList[i].expLabour += Global.planetList[i].popGrowth / 3;
            }
        }


    }
}
