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
            updatePlanet();
            // updateHolding();
            // updateActor();
            // updateStarlane();
            // updateMilitary();
            Program.Save();

        }

        public void updatePlanet()
        {
            for (int i = 0; i < Global.highPID; i++)
            {
                //Population updating
                Global.planetList[i].totalPop += Global.planetList[i].popGrowth;
                Global.planetList[i].genLabour += Global.planetList[i].popGrowth / 3;
                Global.planetList[i].expLabour += Global.planetList[i].popGrowth / 3;
                //Consume resources
                Global.planetList[i].foodReserve -= Global.planetList[i].totalPop / 2;
                Global.planetList[i].mineralReserve -= Global.planetList[i].totalPop / 2;
                Global.planetList[i].energyReserve -= Global.planetList[i].totalPop / 2;
                //Update popGrowth
                Global.planetList[i].popGrowth += Global.planetList[i].foodReserve*2; //Add other two resources. Make this not go to 0 all the time.

                //Update Wealth
                //Update EduLevel
            }
        }

        public void updateHolding()
        {

        }

        public void updateActor()
        {

        }

        public void updateStarlane()
        {

        }

        public void updateMilitary()
        {

        }


    }
}
