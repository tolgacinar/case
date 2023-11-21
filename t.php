<?php
class Developer
{
  public $name;
  public $workload = 0;
  public $difficultyPerHour;
  function __construct($name, $difficultyPerHour)
  {
    $this->name = $name;
    $this->difficultyPerHour = $difficultyPerHour;
  }
}

class Task
{
  public $name;
  public $duration;
  public $difficulty;
  function __construct($name, $duration, $difficulty)
  {
    $this->name = $name;
    $this->duration = $duration;
    $this->difficulty = $difficulty;
  }
}

function assignTasks($developers, $tasks)
{
  usort($tasks, function ($a, $b) {
    return $b->difficulty - $a->difficulty;
  });

  $week = 0;
  while (count($tasks) > 0) {
    $week++;
    echo "Week $week\n";
    foreach ($developers as $developer) {
      $developer->workload = 0;
    }

    foreach ($tasks as $key => $task) {
      usort($developers, function ($a, $b) {
        return $a->workload - $b->workload;
      });

      foreach ($developers as $developer) {
        if ($developer->difficultyPerHour >= $task->difficulty && $developer->workload + $task->duration <= 45) {
          $developer->workload += $task->duration;
          $developer->tasks[$week][] = $task;
          echo $developer->name . " assigned " . $task->name . "<br>";
          unset($tasks[$key]);
          break;
        }
      }
    }
  }

  return $developers;
}

$developers = [new Developer("Developer 1", 1), new Developer("Developer 2", 2), new Developer("Developer 3", 3), new Developer("Developer 4", 4), new Developer("Developer 5", 5)];
$tasklist = json_decode('[
  {
    "zorluk": 3,
    "sure": 6,
    "id": "IT Task 0"
  },
  {
    "zorluk": 4,
    "sure": 6,
    "id": "IT Task 1"
  },
  {
    "zorluk": 3,
    "sure": 10,
    "id": "IT Task 2"
  },
  {
    "zorluk": 4,
    "sure": 4,
    "id": "IT Task 3"
  },
  {
    "zorluk": 3,
    "sure": 5,
    "id": "IT Task 4"
  },
  {
    "zorluk": 1,
    "sure": 12,
    "id": "IT Task 5"
  },
  {
    "zorluk": 1,
    "sure": 4,
    "id": "IT Task 6"
  },
  {
    "zorluk": 5,
    "sure": 6,
    "id": "IT Task 7"
  },
  {
    "zorluk": 3,
    "sure": 8,
    "id": "IT Task 8"
  },
  {
    "zorluk": 1,
    "sure": 6,
    "id": "IT Task 9"
  },
  {
    "zorluk": 2,
    "sure": 10,
    "id": "IT Task 10"
  },
  {
    "zorluk": 1,
    "sure": 6,
    "id": "IT Task 11"
  },
  {
    "zorluk": 4,
    "sure": 11,
    "id": "IT Task 12"
  },
  {
    "zorluk": 5,
    "sure": 3,
    "id": "IT Task 13"
  },
  {
    "zorluk": 1,
    "sure": 11,
    "id": "IT Task 14"
  },
  {
    "zorluk": 4,
    "sure": 6,
    "id": "IT Task 15"
  },
  {
    "zorluk": 5,
    "sure": 4,
    "id": "IT Task 16"
  },
  {
    "zorluk": 3,
    "sure": 11,
    "id": "IT Task 17"
  },
  {
    "zorluk": 2,
    "sure": 11,
    "id": "IT Task 18"
  },
  {
    "zorluk": 3,
    "sure": 8,
    "id": "IT Task 19"
  },
  {
    "zorluk": 3,
    "sure": 11,
    "id": "IT Task 20"
  },
  {
    "zorluk": 1,
    "sure": 5,
    "id": "IT Task 21"
  },
  {
    "zorluk": 4,
    "sure": 5,
    "id": "IT Task 22"
  },
  {
    "zorluk": 2,
    "sure": 7,
    "id": "IT Task 23"
  },
  {
    "zorluk": 2,
    "sure": 6,
    "id": "IT Task 24"
  },
  {
    "zorluk": 3,
    "sure": 9,
    "id": "IT Task 25"
  },
  {
    "zorluk": 4,
    "sure": 6,
    "id": "IT Task 26"
  },
  {
    "zorluk": 4,
    "sure": 7,
    "id": "IT Task 27"
  },
  {
    "zorluk": 1,
    "sure": 4,
    "id": "IT Task 28"
  },
  {
    "zorluk": 4,
    "sure": 5,
    "id": "IT Task 29"
  },
  {
    "zorluk": 5,
    "sure": 9,
    "id": "IT Task 30"
  },
  {
    "zorluk": 2,
    "sure": 5,
    "id": "IT Task 31"
  },
  {
    "zorluk": 2,
    "sure": 5,
    "id": "IT Task 32"
  },
  {
    "zorluk": 2,
    "sure": 6,
    "id": "IT Task 33"
  },
  {
    "zorluk": 5,
    "sure": 6,
    "id": "IT Task 34"
  },
  {
    "zorluk": 1,
    "sure": 10,
    "id": "IT Task 35"
  },
  {
    "zorluk": 1,
    "sure": 10,
    "id": "IT Task 36"
  },
  {
    "zorluk": 1,
    "sure": 10,
    "id": "IT Task 37"
  },
  {
    "zorluk": 5,
    "sure": 12,
    "id": "IT Task 38"
  },
  {
    "zorluk": 4,
    "sure": 12,
    "id": "IT Task 39"
  },
  {
    "zorluk": 2,
    "sure": 6,
    "id": "IT Task 40"
  },
  {
    "zorluk": 3,
    "sure": 8,
    "id": "IT Task 41"
  },
  {
    "zorluk": 5,
    "sure": 10,
    "id": "IT Task 42"
  },
  {
    "zorluk": 3,
    "sure": 10,
    "id": "IT Task 43"
  },
  {
    "zorluk": 5,
    "sure": 8,
    "id": "IT Task 44"
  },
  {
    "zorluk": 5,
    "sure": 9,
    "id": "IT Task 45"
  },
  {
    "zorluk": 3,
    "sure": 3,
    "id": "IT Task 46"
  },
  {
    "zorluk": 4,
    "sure": 4,
    "id": "IT Task 47"
  },
  {
    "zorluk": 1,
    "sure": 12,
    "id": "IT Task 48"
  },
  {
    "zorluk": 1,
    "sure": 7,
    "id": "IT Task 49"
  },
  {
    "zorluk": 1,
    "sure": 4,
    "id": "IT Task 50"
  },
  {
    "zorluk": 1,
    "sure": 10,
    "id": "IT Task 51"
  },
  {
    "zorluk": 4,
    "sure": 8,
    "id": "IT Task 52"
  },
  {
    "zorluk": 3,
    "sure": 3,
    "id": "IT Task 53"
  },
  {
    "zorluk": 4,
    "sure": 10,
    "id": "IT Task 54"
  },
  {
    "zorluk": 4,
    "sure": 12,
    "id": "IT Task 55"
  },
  {
    "zorluk": 3,
    "sure": 10,
    "id": "IT Task 56"
  },
  {
    "zorluk": 2,
    "sure": 11,
    "id": "IT Task 57"
  },
  {
    "zorluk": 1,
    "sure": 7,
    "id": "IT Task 58"
  },
  {
    "zorluk": 2,
    "sure": 4,
    "id": "IT Task 59"
  },
  {
    "zorluk": 3,
    "sure": 4,
    "id": "IT Task 60"
  },
  {
    "zorluk": 1,
    "sure": 3,
    "id": "IT Task 61"
  },
  {
    "zorluk": 1,
    "sure": 6,
    "id": "IT Task 62"
  },
  {
    "zorluk": 3,
    "sure": 3,
    "id": "IT Task 63"
  },
  {
    "zorluk": 4,
    "sure": 12,
    "id": "IT Task 64"
  },
  {
    "zorluk": 2,
    "sure": 11,
    "id": "IT Task 65"
  },
  {
    "zorluk": 3,
    "sure": 10,
    "id": "IT Task 66"
  },
  {
    "zorluk": 3,
    "sure": 6,
    "id": "IT Task 0"
  },
  {
    "zorluk": 4,
    "sure": 6,
    "id": "IT Task 1"
  },
  {
    "zorluk": 3,
    "sure": 10,
    "id": "IT Task 2"
  },
  {
    "zorluk": 4,
    "sure": 4,
    "id": "IT Task 3"
  },
  {
    "zorluk": 3,
    "sure": 5,
    "id": "IT Task 4"
  },
  {
    "zorluk": 1,
    "sure": 12,
    "id": "IT Task 5"
  },
  {
    "zorluk": 1,
    "sure": 4,
    "id": "IT Task 6"
  },
  {
    "zorluk": 5,
    "sure": 6,
    "id": "IT Task 7"
  },
  {
    "zorluk": 3,
    "sure": 8,
    "id": "IT Task 8"
  },
  {
    "zorluk": 1,
    "sure": 6,
    "id": "IT Task 9"
  },
  {
    "zorluk": 2,
    "sure": 10,
    "id": "IT Task 10"
  },
  {
    "zorluk": 1,
    "sure": 6,
    "id": "IT Task 11"
  },
  {
    "zorluk": 4,
    "sure": 11,
    "id": "IT Task 12"
  },
  {
    "zorluk": 5,
    "sure": 3,
    "id": "IT Task 13"
  },
  {
    "zorluk": 1,
    "sure": 11,
    "id": "IT Task 14"
  },
  {
    "zorluk": 4,
    "sure": 6,
    "id": "IT Task 15"
  },
  {
    "zorluk": 5,
    "sure": 4,
    "id": "IT Task 16"
  },
  {
    "zorluk": 3,
    "sure": 11,
    "id": "IT Task 17"
  },
  {
    "zorluk": 2,
    "sure": 11,
    "id": "IT Task 18"
  },
  {
    "zorluk": 3,
    "sure": 8,
    "id": "IT Task 19"
  },
  {
    "zorluk": 3,
    "sure": 11,
    "id": "IT Task 20"
  },
  {
    "zorluk": 1,
    "sure": 5,
    "id": "IT Task 21"
  },
  {
    "zorluk": 4,
    "sure": 5,
    "id": "IT Task 22"
  },
  {
    "zorluk": 2,
    "sure": 7,
    "id": "IT Task 23"
  },
  {
    "zorluk": 2,
    "sure": 6,
    "id": "IT Task 24"
  },
  {
    "zorluk": 3,
    "sure": 9,
    "id": "IT Task 25"
  },
  {
    "zorluk": 4,
    "sure": 6,
    "id": "IT Task 26"
  },
  {
    "zorluk": 4,
    "sure": 7,
    "id": "IT Task 27"
  },
  {
    "zorluk": 1,
    "sure": 4,
    "id": "IT Task 28"
  },
  {
    "zorluk": 4,
    "sure": 5,
    "id": "IT Task 29"
  },
  {
    "zorluk": 5,
    "sure": 9,
    "id": "IT Task 30"
  },
  {
    "zorluk": 2,
    "sure": 5,
    "id": "IT Task 31"
  },
  {
    "zorluk": 2,
    "sure": 5,
    "id": "IT Task 32"
  },
  {
    "zorluk": 2,
    "sure": 6,
    "id": "IT Task 33"
  },
  {
    "zorluk": 5,
    "sure": 6,
    "id": "IT Task 34"
  },
  {
    "zorluk": 1,
    "sure": 10,
    "id": "IT Task 35"
  },
  {
    "zorluk": 1,
    "sure": 10,
    "id": "IT Task 36"
  },
  {
    "zorluk": 1,
    "sure": 10,
    "id": "IT Task 37"
  },
  {
    "zorluk": 5,
    "sure": 12,
    "id": "IT Task 38"
  },
  {
    "zorluk": 4,
    "sure": 12,
    "id": "IT Task 39"
  },
  {
    "zorluk": 2,
    "sure": 6,
    "id": "IT Task 40"
  },
  {
    "zorluk": 3,
    "sure": 8,
    "id": "IT Task 41"
  },
  {
    "zorluk": 5,
    "sure": 10,
    "id": "IT Task 42"
  },
  {
    "zorluk": 3,
    "sure": 10,
    "id": "IT Task 43"
  },
  {
    "zorluk": 5,
    "sure": 8,
    "id": "IT Task 44"
  },
  {
    "zorluk": 5,
    "sure": 9,
    "id": "IT Task 45"
  },
  {
    "zorluk": 3,
    "sure": 3,
    "id": "IT Task 46"
  },
  {
    "zorluk": 4,
    "sure": 4,
    "id": "IT Task 47"
  },
  {
    "zorluk": 1,
    "sure": 12,
    "id": "IT Task 48"
  },
  {
    "zorluk": 1,
    "sure": 7,
    "id": "IT Task 49"
  },
  {
    "zorluk": 1,
    "sure": 4,
    "id": "IT Task 50"
  },
  {
    "zorluk": 1,
    "sure": 10,
    "id": "IT Task 51"
  },
  {
    "zorluk": 4,
    "sure": 8,
    "id": "IT Task 52"
  },
  {
    "zorluk": 3,
    "sure": 3,
    "id": "IT Task 53"
  },
  {
    "zorluk": 4,
    "sure": 10,
    "id": "IT Task 54"
  },
  {
    "zorluk": 4,
    "sure": 12,
    "id": "IT Task 55"
  },
  {
    "zorluk": 3,
    "sure": 10,
    "id": "IT Task 56"
  },
  {
    "zorluk": 2,
    "sure": 11,
    "id": "IT Task 57"
  },
  {
    "zorluk": 1,
    "sure": 7,
    "id": "IT Task 58"
  },
  {
    "zorluk": 2,
    "sure": 4,
    "id": "IT Task 59"
  },
  {
    "zorluk": 3,
    "sure": 4,
    "id": "IT Task 60"
  },
  {
    "zorluk": 1,
    "sure": 3,
    "id": "IT Task 61"
  },
  {
    "zorluk": 1,
    "sure": 6,
    "id": "IT Task 62"
  },
  {
    "zorluk": 3,
    "sure": 3,
    "id": "IT Task 63"
  },
  {
    "zorluk": 4,
    "sure": 12,
    "id": "IT Task 64"
  },
  {
    "zorluk": 2,
    "sure": 11,
    "id": "IT Task 65"
  },
  {
    "zorluk": 3,
    "sure": 10,
    "id": "IT Task 66"
  }
]', true);
foreach ($tasklist as $key => $value) {
  $tasks[] = new Task($value['id'], $value['sure'], $value['zorluk']);
}

$developers = assignTasks($developers, $tasks);

echo "<pre>";
print_r($developers);
echo "</pre>";

foreach ($developers as $developer) {
  // echo $developer->name . " workload: " . $developer->workload . " hours" . "<br>";
}
