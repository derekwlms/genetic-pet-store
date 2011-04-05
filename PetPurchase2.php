<?php
/**
 * PetPurchase.php - PetPurchase - A candidate solution (individual/chromosome)
 *                   for a $100 / 100-item pet store purchase.
 * See: http://derekwilliams.us/?p=4872.
 */

class PetPurchase2 {

    // Instance:

    // Use instance variables to encode the chromosome / genotype.
    // For a more traditional approach, we could use
    // an array - [dogCount, catCount, mouseCount].

    private $dogCount, $catCount, $mouseCount;

    public function getDogCount() { return $this->dogCount; }
    public function setDogCount($count) { $this->dogCount = $count; }
    public function getCatCount() { return $this->catCount; }
    public function setCatCount($count) { $this->catCount = $count; }
    public function getMouseCount() { return $this->mouseCount; }
    public function setMouseCount($count) { $this->mouseCount = $count; }

    public function getTotalCount() {
        return $this->getDogCount() +
                $this->getCatCount() +
                $this->getMouseCount();
    }
    public function getTotalCost() {
        return ($this->getDogCount() * 15) +
                $this->getCatCount() +
               ($this->getMouseCount() * 0.25);
    }

    /**
     * Generate a random set of counts, within reasonable constraints.
     */
    public function randomize() {
        $this->setDogCount(rand(1,6));
        $this->setCatCount(rand(1,85));
        $this->setMouseCount(rand(1,336));
    }

    /**
     * Return the fitness of this solution as a score
     * from 0 (worst) to 100 (perfect).
     * See: http://en.wikipedia.org/wiki/Fitness_function.
     */
    public function getFitness() {

        // There must be at least one of each animal:
        if ($this->getDogCount() == 0 ||
            $this->getCatCount() == 0 ||
             $this->getMouseCount() == 0)
            return 0;

        $countError = abs(100 - $this->getTotalCount());
        $amountError = abs(100 - $this->getTotalCost());

        if ($countError > 50 || $amountError > 50)
            return 0;
        else
            return 100 - ($countError + $amountError);
    }

    /**
     * Set my attributes from those of my parents.
     * This is also known as breeding, crossover, or recombination.
     */
    public function combine($dad, $mom) {
        $this->setDogCount(rand(0,1) == 0 ?
                            $dad->getDogCount() : $mom->getDogCount());
        $this->setCatCount(rand(0,1) == 0 ?
                            $dad->getCatCount() : $mom->getCatCount());
        $this->setMouseCount(rand(0,1) == 0 ?
                            $dad->getMouseCount() : $mom->getMouseCount());
    }

    /**
     * Mutate my attributes so that I'm not an exact clone of my parents.
     */
    public function mutate() {
        $this->setDogCount(rand(0,2) == 0 ?
                            rand(1,6) : $this->getDogCount());
        $this->setCatCount(rand(0,2) == 0 ?
                            rand(1,85) : $this->getCatCount());
        $this->setMouseCount(rand(0,2) == 0 ?
                            rand(1,336) : $this->getMouseCount());
    }

    // Class (static):

    /**
     * Create/initialize a population of the given size with random individuals.
     */
    public static function createPopulation($size) {
        $population = array();
        for ($i=0; $i<$size; $i++) {
            $purchase = new PetPurchase();
            $purchase->randomize();
            array_push($population, $purchase);
        }
        return $population;
    }

    /**
     * Select a subset of the given population for breeding a new generation.
     * Return this subset ordered by the most fit first.
     */
      public static function select($population, $size) {
        // TODO
      }

    /**
     * Breed the items in the given population to produce a new generation.
     * We'll breed 2 kids for each pair of parents.
     */
      public static function breed($population) {
          $nextGeneration = array();
          for ($i=0; $i<count($population); $i+=2) {
              $dad = $population[$i];
              $mom = $population[$i+1];
              $kid1 = new PetPurchase();
              $kid1->combine($dad, $mom);
              array_push($nextGeneration, $kid1);
              $kid2 = new PetPurchase();
              $kid2->combine($dad, $mom);
              $kid2->mutate();  // evil twin
              array_push($nextGeneration, $kid2);
          }
          return $nextGeneration;
      }

    /**
     * Find the most fit solution by breeding the given number of generations,
     * each with the specified population size.
     * Answer an array with the most fit and the number of generations created.
     */
      public static function findMostFit($generations, $populationSize) {
        // TODO
      }
}
?>