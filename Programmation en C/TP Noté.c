//Programme repliquant une pseudo interface midi
//TP Noté de Programmation en C en L2 S3 à l'UPEC en 2019


#include <stdlib.h>
#include <stdio.h>
#define prl { printf("\n"); }

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

#define C  0   // Do
#define D  2   // R�
#define E  4   // Mi
#define F  5   // Fa
#define G  7   // Sol
#define A  9   // La
#define B 11   // Si

#define Cs  1  // Do di�se / R� b�mol
#define Ef  3  // Mi b�mol / R� di�se
#define Fs  6  // Fa di�se / Sol b�mol
#define Af  8  // La b�mol / Sol di�se
#define Bf 10  // Si b�mol / La di�se

typedef unsigned char pitch_t;

pitch_t pitch(unsigned char pitch_class, unsigned char octave) {

    unsigned char t;
    unsigned char note;
    t = pitch_class << 4;     //d�calage � gauche de pitch class par 4
    note = t|octave; //Le ou logique permet de faire une addition de pitch_class et de octave et comme pitch class est de 4 bits et libre on retrouve effectivement une~concatenaison des deux
    return note;

}

void print_pitch(pitch_t p) {
    unsigned char octave,pclass;
    pclass = p;
    pclass = pclass >> 4; // on retrouve pitch class en faisant un decalage a droite
    octave = p;
    octave=octave << 4;    // pas la m�thode la plus propre mais fait l'affaire avec un unsigned char pour eliminer les bits de poid
    octave=octave >> 4;
    switch(pclass){
        case 0: printf("C"); break;     //If it works, it works
        case 1: printf("C#"); break;
        case 2: printf("D"); break;
        case 3: printf("Eb"); break;
        case 4: printf("E"); break;
        case 5: printf("F"); break;
        case 6: printf("F#"); break;
        case 7: printf("G"); break;
        case 8: printf("Af"); break;
        case 9: printf("A"); break;
        case 10: printf("Bb"); break;
        case 11: printf("B");
    }
    printf("%hhd",octave);
}



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

typedef enum{

    Piano,
    Guitar,
    Organ,
    Bass

}instrument_t;

typedef enum{

    Delay,
    Instrument_Change,
    Note_Start,
    Note_End

}event_type_t;

typedef struct{

    unsigned int tick;

}delay_t;

typedef struct{

    unsigned char canal;
    instrument_t instrument;

}instrument_change_t;

typedef struct{

    unsigned char canal;
    pitch_t note;
    unsigned char volume;

}note_on_t;

typedef struct{

    unsigned char canal;
    pitch_t note;

}note_off_t;

typedef union{

    delay_t delay;
    instrument_change_t instrument_change;
    note_on_t note_start;
    note_off_t note_end;

}event_description_t;


typedef struct{


    event_type_t event_type;
    event_description_t event_description;

}event_t;

event_t delay(unsigned int n) {

  event_t delay;
  delay.event_description.delay.tick = n;
  delay.event_type = Delay;
  return delay;

}

event_t instrument(unsigned char chan, instrument_t inst){

    event_t instrum;
    instrum.event_description.instrument_change.canal=chan;
    instrum.event_description.instrument_change.instrument=inst;
    instrum.event_type = Instrument_Change;
    return instrum;

}

event_t note_on(unsigned char chan, pitch_t p, unsigned char vol) {

    event_t noteon;
    noteon.event_description.note_start.canal=chan;
    noteon.event_description.note_start.note=p;
    noteon.event_description.note_start.volume=vol;
    noteon.event_type = Note_Start;
    return noteon;

}

event_t note_off(unsigned char chan, pitch_t p) {

    event_t noteoff;
    noteoff.event_description.note_end.canal = chan;
    noteoff.event_description.note_end.note = p;
    noteoff.event_type = Note_End;
    return noteoff;

}

void print_event(event_t e) {
    char *str;
    int size = 7;
    str = (char *)malloc(sizeof(char)*size);                        //Declaration of a variable to store the possible choice of instruments
    switch(e.event_description.instrument_change.instrument){
        case Bass: *(str+0) = 'B';  *(str+1) = 'a';   *(str+2) = 's';   *(str+3) = 's'; *(str+4) = '\0'; *(str+5) = '\0'; *(str+6) = '\0'; break;
        case Guitar: *(str+0) = 'G';  *(str+1) = 'u';   *(str+2) = 'i';   *(str+3) = 't'; *(str+4) = 'a'; *(str+5) = 'r'; *(str+6) = '\0';break;
        case Piano: *(str+0) = 'P';  *(str+1) = 'i';   *(str+2) = 'a';   *(str+3) = 'n'; *(str+4) = 'o'; *(str+5) = '\0'; *(str+6) = '\0';break;
        case Organ: *(str+0) = 'O';  *(str+1) = 'r';   *(str+2) = 'g';   *(str+3) = 'a'; *(str+4) = 'n'; *(str+5) = '\0'; *(str+6) = '\0';
    }
    switch(e.event_type){
        case Delay: printf("Wait for %hhd tick(s)", e.event_description.delay.tick); break;
        case Instrument_Change: printf("Channel %hhd sounds now like a %s", e.event_description.instrument_change.canal, str); break;
        case Note_Start: printf("Play "); print_pitch(e.event_description.note_start.note); printf(" on channel %hhd", e.event_description.note_start.canal); printf(" at volume %hhd", e.event_description.note_start.volume); break;
        case Note_End: printf("Stop playing "); print_pitch(e.event_description.note_end.note); printf(" on channel %hhd", e.event_description.note_end.canal);
  }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


int main() {
  pitch_t p1 = pitch(C,4);
  pitch_t p2 = pitch(Fs,3);
  pitch_t p3 = pitch(G,5);
  print_pitch(p1); prl;
  print_pitch(p2); prl;
  print_pitch(p3); prl;
  prl;

  int i = 0;
  event_t music[100];
  music[i++] = instrument(0, Bass);
  music[i++] = instrument(1, Guitar);
  music[i++] = note_on(0, pitch(C,3), 25);
  music[i++] = note_on(1, pitch(C,4), 50);
  music[i++] = delay(1);
  music[i++] = note_off(1, pitch(C,4));
  music[i++] = delay(1);
  music[i++] = note_on(1, pitch(C,4), 30);
  music[i++] = delay(1);
  music[i++] = note_off(1, pitch(C,4));
  music[i++] = delay(1);
  music[i++] = note_on(1, pitch(G,4), 50);
  music[i++] = delay(1);
  music[i++] = note_off(1, pitch(G,4));
  music[i++] = delay(1);
  music[i++] = note_on(1, pitch(G,4), 30);
  music[i++] = delay(1);
  music[i++] = note_off(0, pitch(C,3));
  music[i++] = note_off(1, pitch(G,4));
  music[i++] = delay(1);
  music[i++] = note_on(0, pitch(F,3), 25);
  music[i++] = note_on(1, pitch(A,4), 50);
  music[i++] = delay(1);
  music[i++] = note_off(1, pitch(A,4));
  music[i++] = delay(1);
  music[i++] = note_on(1, pitch(A,4), 30);
  music[i++] = delay(1);
  music[i++] = note_off(0, pitch(F,3));
  music[i++] = note_off(1, pitch(A,4));
  music[i++] = delay(1);
  music[i++] = note_on(0, pitch(E,3), 25);
  music[i++] = note_on(1, pitch(C,4), 50);
  music[i++] = delay(4);
  music[i++] = note_off(0, pitch(C,3));
  music[i++] = note_off(1, pitch(C,4));

  int j;
  for(j = 0; j < i; j++) {
    print_event(music[j]);
    prl;
  }
  return EXIT_SUCCESS;
}
