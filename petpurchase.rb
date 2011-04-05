# PetPurchase - A candidate solution (individual/chromosome) for a $100 / 100-item pet store purchase.
# See: http://derekwilliams.us/?p=4886.

class PetPurchase

  attr_accessor :dog_count, :cat_count, :mouse_count, :generation

  def initialize(dog_count, cat_count, mouse_count)
    @dog_count = dog_count
    @cat_count = cat_count
    @mouse_count = mouse_count
  end

  def total_count
    return dog_count + cat_count + mouse_count
  end
  def total_cost
    return (dog_count * 15) + cat_count + (mouse_count * 0.25)
  end

  # Generate a random set of counts, within reasonable constraints.
  def randomize
    @dog_count = rand(6) + 1;
    @cat_count = rand(85) + 1;
    @mouse_count = rand(336) + 1;
    return self
  end

  # Return the fitness of this solution as a score
  # from 0 (worst) to 100 (perfect).
  # See: http://en.wikipedia.org/wiki/Fitness_function.
  def fitness
    if dog_count == 0 || cat_count == 0 || mouse_count == 0
      return 0;
    end
    count_error = (100 - total_count).abs
    amount_error = (100 - total_cost).abs
    if count_error > 50 || amount_error > 50
      return 0
    else
      return 100 - (count_error + amount_error) 
    end
  end

  # Set my attributes from those of my parents.
  # This is also known as breeding, crossover, or recombination.
  def combine(dad, mom)
    @dog_count = rand(2) == 0 ? dad.dog_count : mom.dog_count
    @cat_count = rand(2) == 0 ? dad.cat_count : mom.cat_count
    @mouse_count = rand(2) == 0 ? dad.mouse_count : mom.mouse_count
  end

  # Mutate my attributes so that I'm not an exact clone of my parents.
  def mutate
    @dog_count = rand(2) == 0 ? 1 + rand(6) : dog_count
    @cat_count = rand(2) == 0 ? 1 + rand(85) : cat_count
    @mouse_count = rand(2) == 0 ? 1 + rand(336) : mouse_count
  end

  # Compare fitness levels for sorting (spaceship).
  def <=>(other)
    other.fitness <=> self.fitness
  end

  # Create/initialize a population of the given size with random individuals.
  def self.create_population(size)
    return (1..size).collect { self.new(0,0,0).randomize }
  end

  # Select a subset of the given population for breeding a new generation.
  # Return this subset ordered by the most fit first.
  def self.select(population, size)
    return population.sort.slice(0..size)
  end

  # Breed the items in the given population to produce a new generation.
  # We'll breed 2 kids for each pair of parents.
  def self.breed(population)
    next_generation = []
    0.step(population.length - 1, 2) do |i|
      dad = population[i]
      mom = population[i+1]
      kid1 = self.new(0,0,0)
      kid1.combine(dad, mom)
      next_generation.push(kid1)
      kid2 = self.new(0,0,0)
      kid2.combine(dad, mom)
      kid2.mutate        # evil twin
      next_generation.push(kid2)
    end
    return next_generation
  end

  # Find the most fit solution by breeding the given number of generations,
  # each with the specified population size.
  def self.find_most_fit(generations, population_size)
    population = self.create_population(population_size)
    most_fit = self.new(0,0,0)
    generations.times do | generation |
      population = self::select(population, population_size)
      if population[0].fitness > most_fit.fitness
        most_fit = population[0]
	most_fit.generation = generation
      end
      break if most_fit.fitness == 100
      population = self::breed(population)
    end
    return most_fit
  end
end

best = PetPurchase.find_most_fit(20000, 30)
printf("Dogs: %d, Cats: %d, Mice: %d, Fitness: %d, Generation %d\n", 
         best.dog_count, best.cat_count, best.mouse_count, best.fitness, best.generation)
