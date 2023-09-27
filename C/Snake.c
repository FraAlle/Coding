#include <ctype.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <time.h>

int main() {
  srand(time(NULL));
  int colonne;
  int righe;
  int entrata;
  int uscita;
  int i;
  int y;
  int k;
  int muroX;
  int muroY;
  int direzioneMuro;  // 0 verticale 1 orizzontale
  int followOstacoli; // quanti ostacoli voglio
  int nWalls;
  int nMoney;
  int moneyX;
  int moneyY;
  int nTrapani;
  int trapanoX;
  int trapanoY;
  int nImpr;
  int imprevistiX;
  int imprevistiY;
  int lunghezza;
  char select;
  int j = 0;
  int monete = 0, punteggio = 1000, numeroPassi = 0, pass_wall = 0;
  char direzione;
  int uscito = 0;

  printf("Quante colonne vuoi? \n");
  scanf("%d", &colonne);
  printf("Quante righe vuoi? \n");
  scanf("%d", &righe);
  entrata = rand() % (righe - 1 - 1) + 1;
  uscita = rand() % (righe - 1 - 1) + 1;

  // buildare ostacoli prima del labrinto in se
  char labirinto[colonne][righe];
  char visitato[colonne][righe];
  int maxNumber = ((colonne + righe - 2) * 50) / 100;
  nWalls = rand() % (maxNumber + 1 - 1) + 1;
  nMoney = rand() % ((righe / 4) + 1 - 1) + 1;
  nTrapani = rand() % ((righe / 5) + 1 - 1) + 1;
  nImpr = rand() % ((righe / 3) + 1 - 1) + 1;

  // MURI
  for (int g = 0; g < nWalls; g++) {
    muroX = rand() % (righe - 1 - 1) + 1;
    muroY = rand() % (colonne - 1 - 1) + 1;
    labirinto[muroY][muroX] = '#';
    visitato[muroY][muroX] = '#';
    direzioneMuro = rand() % (1 + 1 - 0) + 0;
    if (direzioneMuro == 0) { // 0 = righe
      followOstacoli = rand() % ((righe / 2) + 1 - 1) + 1;
      for (int n = 0; n < followOstacoli; n++) {
        labirinto[muroY][muroX + n] = '#';
        visitato[muroY][muroX + n] = '#';
      }
    } else { // 1 per le colonne
      followOstacoli = rand() % ((colonne / 2) + 1 - 1) + 1;
      for (int m = 0; m < followOstacoli; m++) {
        labirinto[muroY + m][muroX] = '#';
        visitato[muroY + m][muroX] = '#';
      }
    }
  }

  // IMPREVISTI
  for (int w = 0; w < nImpr; w++) {
    imprevistiX = rand() % (righe - 1 - 1) + 1;
    imprevistiY = rand() % (colonne - 1 - 1) + 1;
    if (labirinto[imprevistiY][imprevistiX] != '#') {
      labirinto[imprevistiY][imprevistiX] = '!';
      visitato[imprevistiY][imprevistiX] = '!';
    }
  }

  // MONETE
  for (int a = 0; a < nMoney; a++) {
    moneyX = rand() % (righe - 1 - 1) + 1;
    moneyY = rand() % (colonne - 1 - 1) + 1;
    if (labirinto[moneyY][moneyX] != '#' && labirinto[moneyY][moneyX] != '!') {
      labirinto[moneyY][moneyX] = '$';
      visitato[moneyY][moneyX] = '$';
    }
  }

  // TRAPANI
  for (int q = 0; q < nTrapani; q++) {
    trapanoX = rand() % (righe - 1 - 1) + 1;
    trapanoY = rand() % (colonne - 1 - 1) + 1;
    if (labirinto[moneyY][moneyX] != '!' && labirinto[moneyY][moneyX] != '$') {
      labirinto[trapanoY][trapanoX] = 'T';
      visitato[trapanoY][trapanoX] = 'T';
    }
  }

  // CREZIONE ARRAY
  for (y = 0; y < righe; y++) {     // quest va a mettere i verticali
    for (i = 0; i < colonne; i++) { // questo l'orrizzontale
      if (y == 0 || y == (righe - 1) || i == 0 || i == (colonne - 1)) {
        if (y == entrata && i == 0) {
          labirinto[y][0] = 'o'; // memorizzazione entrata
          visitato[y][0] = 'o';  // memorizzazione entrata
        } else if (y == uscita && i == colonne - 1) {
          labirinto[y][i] = '_'; // memorizzazione uscita
          visitato[y][i] = '_';  // memorizzazione uscita
        } else {
          labirinto[y][i] = '#'; // memorizzazione muro laterale
          visitato[y][i] = '#';
        }
      } // chisura  if iniziale
      else if (labirinto[y][i] != '#' && labirinto[y][i] != '$' &&
               labirinto[y][i] != 'T' && labirinto[y][i] != '!') {
        labirinto[y][i] = ' '; // memorizzazione spazio
        visitato[y][i] = '0';  // memorizzazione spazio
      }
       printf("%c", labirinto[y][i]);
    } // chiusura for i
  printf("\n");
  } // chiusura for y
  printf("Primo Labirinto\n");

  // MOVIMENTI
  while (uscito == 0) {
    int trovato = 0;
    // chiedere in input la direzione (N, S, E, O)
    printf("Inserisci direzione: \n(N, S, E,O)\n");
    scanf("%c", &direzione);
    direzione = toupper(direzione);

    // uso uno switch per verificare i vari casi di input
    switch (direzione) {
    case 'N':
      for (y = 0; y < righe; y++) { // quest va a mettere i verticali
        for (i = 0; i < colonne; i++) {
          if (labirinto[y][i] == 'o') {
            int z = y - 1;
            if (labirinto[z][i] == '#' && pass_wall > 0) {
              pass_wall--;
              labirinto[z][i] = 'o';
              labirinto[y][i] = ' ';
              printf("Trapani: %d\n", pass_wall);
              break;
            }
            if (labirinto[z][i] == '#') {
              break;
            }
            if (labirinto[z][i] == '_') {
              uscito = 1;
            }
            if (labirinto[z][i] == '$') {
              monete += 10;
            }
            if (labirinto[z][i] == '!') {
              monete -= 10;
            }
            if (labirinto[z][i] == 'T') {
              pass_wall += 3;
            }
            labirinto[z][i] = 'o';
            labirinto[y][i] = ' ';
            break;
          }
        }
      }
      // PRINT
      for (y = 0; y < righe; y++) {     // quest va a mettere i verticali
        for (i = 0; i < colonne; i++) { // questo l'orrizzontale
          printf("%c", labirinto[y][i]);
        } // chiusura for i
        printf("\n");
      } // chiusura for y
      numeroPassi++;
      punteggio--;
      printf("Trapani: %d\n", pass_wall);
      printf("punteggio: %d\n", punteggio);
      printf("Passi: %d\n", numeroPassi);
      break;

    case 'S':
      for (y = 0; y < righe; y++) { // quest va a mettere i verticali
        for (i = 0; i < colonne; i++) {
          if (labirinto[y][i] == 'o') {
            int z = y + 1;
            if (labirinto[z][i] == '#' && pass_wall > 0) {
              pass_wall--;
              labirinto[z][i] = 'o';
              labirinto[y][i] = ' ';
              printf("Trapani: %d\n", pass_wall);
              break;
            }
            if (labirinto[z][i] == '#') {
              break;
            }
            if (labirinto[z][i] == '_') {
              uscito = 1;
            }
            if (labirinto[z][i] == '$') {
              punteggio += 10;
            }
            if (labirinto[z][i] == '!') {
              punteggio -= 10;
            }
            if (labirinto[z][i] == 'T') {
              pass_wall += 3;
            }
            labirinto[z][i] = 'o';
            labirinto[y][i] = ' ';
            break;
          }
        }
        // SOLO PER IL SUD
        if (labirinto[y + 1][i] == 'o') {
          break;
        }
      }
      // PRINT
      for (y = 0; y < righe; y++) {     // quest va a mettere i verticali
        for (i = 0; i < colonne; i++) { // questo l'orrizzontale
          printf("%c", labirinto[y][i]);
        } // chiusura for i
        printf("\n");
      } // chiusura for y
      numeroPassi++;
      punteggio--;
      printf("Trapani: %d\n", pass_wall);
      printf("punteggio: %d\n", punteggio);
      printf("Passi: %d\n", numeroPassi);
      break;

    case 'E':
      for (y = 0; y < righe; y++) { // quest va a mettere i verticali
        for (i = 0; i < colonne; i++) {
          if (labirinto[y][i] == 'o') {
            int z = i + 1;
            if (labirinto[y][z] == '#' && pass_wall > 0) {
              pass_wall--;
              labirinto[y][z] = 'o';
              labirinto[y][i] = ' ';
              printf("Trapani: %d\n", pass_wall);
              break;
            }
            if (labirinto[y][z] == '#') {
              break;
            }
            if (labirinto[y][z] == '_') {
              uscito = 1;
            }
            if (labirinto[y][z] == '$') {
              punteggio += 10;
            }
            if (labirinto[y][z] == '!') {
              punteggio -= 10;
            }
            if (labirinto[y][z] == 'T') {
              pass_wall += 3;
            }
            labirinto[y][z] = 'o';
            labirinto[y][i] = ' ';
            break;
          }
        }
      }
      // PRINT
      for (y = 0; y < righe; y++) {     // quest va a mettere i verticali
        for (i = 0; i < colonne; i++) { // questo l'orrizzontale
          printf("%c", labirinto[y][i]);
        } // chiusura for i
        printf("\n");
      } // chiusura for y
      numeroPassi++;
      punteggio--;
      printf("Trapani: %d\n", pass_wall);
      printf("punteggio: %d\n", punteggio);
      printf("Passi: %d\n", numeroPassi);
      break;

    case 'O':
      for (y = 0; y < righe; y++) { // quest va a mettere i verticali
        for (i = 0; i < colonne; i++) {
          if (labirinto[y][i] == 'o') {
            int z = i - 1;
            if (labirinto[y][z] == '#' && pass_wall > 0) {
              pass_wall--;
              labirinto[y][z] = 'o';
              labirinto[y][i] = ' ';
              break;
            }
            if (labirinto[y][z] == '#') {
              break;
            }
            if (labirinto[y][z] == '_') {
              uscito = 1;
            }
            if (labirinto[y][z] == '$') {
              punteggio += 10;
            }
            if (labirinto[y][z] == '!') {
              punteggio -= 10;
            }
            if (labirinto[y][z] == 'T') {
              pass_wall += 3;
            }
            labirinto[y][z] = 'o';
            labirinto[y][i] = ' ';
            break;
          }
        }
      }
      // PRINT
      for (y = 0; y < righe; y++) {     // quest va a mettere i verticali
        for (i = 0; i < colonne; i++) { // questo l'orrizzontale
          printf("%c", labirinto[y][i]);
        } // chiusura for i
        printf("\n");
      } // chiusura for y
      numeroPassi++;
      punteggio--;
      printf("Trapani: %d\n", pass_wall);
      printf("punteggio: %d\n", punteggio);
      printf("Passi: %d\n", numeroPassi);
      break;
    }
  } // chiusura while;
  printf(
      "CONGRATULAZIONI HAI FINITO IL GIOCO, QUESTO E' IL TUO PUNTEGGIO: \n");
  printf("%d\n", punteggio);
return 0;
}
