<?php
trait Back
{
    protected function Reverse()
    {
        echo "Режим езды назад" . PHP_EOL;
    }
}
trait Forward
{
    protected function ForwardGear()
    {
        echo "Режим езды вперед" . PHP_EOL;
    }
}
trait TransmissionAuto
{
    use Back;
    use Forward;

    protected function AutoTransmission()
    {
        echo "У вас автоматическая коробка передач" . PHP_EOL;
    }
}
trait TransmissionManual
{
    use Back;
    use Forward;
    protected function ManualTransmission()
    {
        echo "У вас механическая коробка передач" . PHP_EOL;
    }

    protected function firstGear()
    {
        echo "Едем на первой передаче" . PHP_EOL;
    }

    protected function secondGear()
    {
        echo "Едем на вторая передаче" . PHP_EOL;
    }
}
trait Engine
{
    protected $capacity = 25;
    protected $temperature = 0;
    public function start()
    {
        echo "Запустили двигатель" . PHP_EOL;
    }
    public function stop()
    {
        echo "Заглушили двигатель" . PHP_EOL;
        echo "Приехали !!!" . PHP_EOL;
    }
    public function cooling()
    {
        $this->temperature -= 10;
        echo "Охлаждаем двигатель на 10 градусов" . PHP_EOL;
        echo "Охлажденная температура " . $this->temperature . PHP_EOL;
    }
}
class Car
{
    use Engine;
    use TransmissionManual, TransmissionAuto {
        TransmissionAuto::Reverse insteadof TransmissionManual;
        TransmissionManual::ForwardGear insteadof TransmissionAuto;
    }

    public $distance;
    public $speed;
    public $destination;
    public $i = 0;
    public $transmissionType;
    public function drive()
    {
        $path = 0;
        while ($path < $this->distance) {
            sleep(1);
            //$path += $this->speed;
            echo "проехали " . $path . " метров " . PHP_EOL;
            for ($this->i; $this->i < $path; $this->i = $this->i + 10) {
                $this->temperature += 5;
                echo "температура двигателя увеличилась на 5 градусов" . PHP_EOL;
                echo "температура: " . $this->temperature . " градусов". PHP_EOL;
            }
            while($this->temperature > 90) {
                $this->cooling();
            }
            $path += $this->speed;
        }
    }
}

class Niva extends Car
{
    function __construct($dist, $speed, $dest, $transmissionType)
    {
        $this->distance = $dist;
        $this->speed = $speed;
        $this->destination = $dest;
        $this->transmissionType = $transmissionType;

        if ($this->transmissionType == "manual") {
            if ($this->speed > ($this->capacity * 2)) {
                echo "Слишком быстро, максимальная " . $this->capacity * 2 . " скорость км" . PHP_EOL;
            } elseif ($this->destination == 1 && $this->speed < 20) {
                $this->start();
                $this->ForwardGear();
                $this->firstGear();
                $this->drive();
                $this->stop();
            } elseif ($this->destination == 1 && $this->speed > 20) {
                $this->start();
                $this->ForwardGear();
                $this->secondGear();
                $this->drive();
                $this->stop();
            } elseif ($this->destination == 0) {
                $this->start();
                $this->Reverse();
                $this->drive();
                $this->stop();
            }
        }elseif ($this->transmissionType == "auto"){
            if ($this->speed > ($this->capacity * 2)) {
                echo "Слишком быстро, максимальная " . $this->capacity * 2 . " скорость км" . PHP_EOL;
            } elseif ($this->destination == "drive" /*&& $this->speed < 20*/) {
                $this->start();
                $this->ForwardGear();
                $this->AutoTransmission();
                $this->drive();
                $this->stop();
            } elseif ($this->destination == 0) {
                $this->start();
                $this->Reverse();
                $this->drive();
                $this->stop();
            }
        }
    }
}

$Niva = new Niva(400, 30, "drive", "auto");
//$Niva->getNiva();