<?php
/**
 * PetPurchase.php - PetPurchase - A candidate solution (individual/chromosome)
 *                   for a $100 / 100-item pet store purchase.
 * See: http://derekwilliams.us/?p=4805.
 */

class PetPurchase1 {

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
        // TODO
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
        // TODO
    }

    /**
     * Mutate my attributes so that I'm not an exact clone of my parents.
     */
    public function mutate() {
        // TODO
    }
}
?>