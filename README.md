## Challenge 042
Recreate Conway's [Game of Life](https://en.wikipedia.org/wiki/Conway%27s_Game_of_Life).

My version of the game uses an array to store a string of characters that act as the grid.  The class converts a given point
into the array position.

When a grid is created, the corners and side points are stored for easy comparison of where a given point lies in order
to process what surrounding points need to be checked.

## Installation

Install the vendor dependencies with Composer:

    $ composer install

## Usage

    $ php game.php <config>
    
    $ php game.php 0 - Animates a glider gun.  This option is set by default.
    $ php game.php 1 - Animates still life.
    $ php game.php 2 - Animates oscilators.
    $ php game.php 3 - Animates a single glider.
    
