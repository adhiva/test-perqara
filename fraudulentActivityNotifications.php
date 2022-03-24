<?php
    class FraudulentActivityNotifications 
    {
        public $n = 0;
        public $d = 0;
        public $expeditions = array();
        public $notifications = 0;

        public $subset = array();
        
        /**
         * mediumByIncrement
         *
         * @param  array $stats
         * @param  mixed $days
         * @return null|bool|int|float|string|array
         */
        public function mediumByIncrement($stats, $days){
            $num = count($stats);
            for($i=0; $i<$num; ++$i) {
                if($stats[$i] > $days) {
                    return $i;
                }
            }
            return -1;
        }
        
        /**
         * getMedium
         *
         * @return null|bool|int|float|string|array
         */
        public function getMedium()
        {
            $sum = 0;
            $stats = array();

            $isEven = (($this->d % 2) == 0) ? true : false;

            for($i=0; $i<200; ++$i){
                $sum += $this->subset[$i];
                $stats[$i] = $sum;
            }

            if(!$isEven) {
                return $this->mediumByIncrement($stats, ($this->d / 2));
            } else {
                return ($this->mediumByIncrement($stats, ($this->d / 2) - 1) + $this->mediumByIncrement($stats, ($this->d / 2))) / 2;
            }
        }

        public function start()
        {
            for($i=0; $i<$this->d; ++$i) {
                $this->subset[$this->expeditions[$i]]++;
            }

            $start = 0;

            for($i=$this->d; $i<$this->n; ++$i) {
                $toAdd = $this->expeditions[$i];
                $medium = $this->getMedium();

                if($toAdd >= 2 * $medium) {
                    $this->notifications++;
                }

                $toRemove = $this->expeditions[$start++];
                $this->subset[$toRemove]--;
                $this->subset[$toAdd]++;
            }
        }
    }

    $getNotifications = new FraudulentActivityNotifications();
    // Set your value of the day here
    $getNotifications->d = [0];
    // Set your value of expenditure here
    $getNotifications->n = [0];

    // Run this notifications 
    $getNotifications->start();
