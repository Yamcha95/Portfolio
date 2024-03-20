#include <ncurses.h>
#include <stdlib.h>
#include <unistd.h>

int length;
int direction;
int *snake;
int headX, headY, fruitX, fruitY, score;

void setup() {
    length = 1;
    direction = 1; // 1: right, 2: left, 3: up, 4: down

    // Initial position of the snake
    headX = 10;
    headY = 10;

    // Initial position of the fruit
    fruitX = 5;
    fruitY = 5;

    score = 0;

    // Allocate memory for the snake
    snake = (int *)malloc(2 * sizeof(int));
    snake[0] = headX;
    snake[1] = headY;

    // Initialize the screen
    initscr();
    clear();
    noecho();
    cbreak();
    keypad(stdscr, TRUE);
}

void draw() {
    clear();

    // Draw fruit
    mvprintw(fruitY, fruitX, "F");

    // Draw snake
    for (int i = 0; i < length * 2; i += 2) {
        mvprintw(snake[i + 1], snake[i], "O");
    }

    // Display score
    mvprintw(0, 0, "Score: %d", score);

    refresh();
}

void input() {
    int ch = getch();

    switch (ch) {
    case KEY_RIGHT:
        if (direction != 2)
            direction = 1;
        break;
    case KEY_LEFT:
        if (direction != 1)
            direction = 2;
        break;
    case KEY_UP:
        if (direction != 4)
            direction = 3;
        break;
    case KEY_DOWN:
        if (direction != 3)
            direction = 4;
        break;
    case 'x':
        endwin();
        free(snake);
        exit(0);
    }
}

void algorithm() {
    int prevX = snake[0];
    int prevY = snake[1];
    int tempX, tempY;

    // Move the head
    switch (direction) {
    case 1:
        headX++;
        break;
    case 2:
        headX--;
        break;
    case 3:
        headY--;
        break;
    case 4:
        headY++;
        break;
    }

    // Check if the head reaches the fruit
    if (headX == fruitX && headY == fruitY) {
        score += 10;

        // Generate new fruit position
        fruitX = rand() % (COLS - 1);
        fruitY = rand() % (LINES - 1);

        // Increase length of the snake
        length += 2;
        snake = (int *)realloc(snake, length * sizeof(int));
    }

    // Move the tail
    for (int i = 2; i < length * 2; i += 2) {
        tempX = snake[i];
        tempY = snake[i + 1];
        snake[i] = prevX;
        snake[i + 1] = prevY;
        prevX = tempX;
        prevY = tempY;
    }

    // Check if the head collides with the snake body
    for (int i = 2; i < length * 2; i += 2) {
        if (headX == snake[i] && headY == snake[i + 1]) {
            endwin();
            free(snake);
            exit(0);
        }
    }

    // Check if the head reaches the screen boundaries
    if (headX >= COLS - 1 || headX < 0 || headY >= LINES - 1 || headY < 0) {
        endwin();
        // free(snake);
        exit(0);
    }

    // Update the snake array with the new head position
    snake[0] = headX;
    snake[1] = headY;

    usleep(100000); // Pause to control the speed of the game
}

int main() {
    setup();

    while (1) {
        draw();
        input();
        algorithm();
    }

    return 0;
}