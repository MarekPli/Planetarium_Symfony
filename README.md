# PLANETARIUM GEOCENTRYCZNE
Program **Planetarium geocentryczne** jest projektem końcowym stacjonarnego kursu bootcamp organizowanego przez firmę 
_CodersLab_, 
który odbył się w kwietniu i maju 2018 r. (```Back-end developer: PHP```). Zgodnie z programem kursu skoncentrowałem się na
 języku PHP i  wykorzystaniu baz danych SQL, a materiał prezentuję na stronie przeglądarki internetowej korzystając 
 z języka JavaScript.
 
 ## Główne założenia
 Program miał przedstawiać położenie planet na niebie z perspektywy geocentrycznej, uwzględniającej współrzędne 
 kątowe,  czyli położenie na ekliptyce. W rozbudowany sposób wykorzystują te dane programy astrologiczne. Niniejszy 
 program przedstawia planety jako obiekty obracające się po kołowych orbitach wokół Ziemi. Pozwala to odczuć i lepiej
  zrozumieć tradycyjne spojrzenie na niebo, przyjmowane przez astronomów epoki przedkopernikańskiej. Jako źródło 
  informacji wykorzystano _Swiss Ephemeris_, udostępniane bezpłatnie do użytku niekomercyjnego na portalu www.astro
  .com:   ```http://www
  .astro
  .com/swisseph/swepha_e.htm``` 
  
  ## Opis programu
   Jedenaście "planet" (w znaczeniu tradycyjnym, w którym do planet lub "świateł" zalicza się także Słońce i Księżyc) 
  umieszczonych jest na współśrodkowych okręgach. Każdej planecie towarzyszy opis (nazwa). Ponadto trzy planety 
  posiadają inny kolor: ```Księżyc``` jest różowo-biały (dzięki temu nie rzuca się przesadnie w oczy, co jest istotne, gdyż
   zwraca na siebie uwagę niewspółmiernie szybkim ruchem), ```Słońce``` jest żółte, a ```Ceres``` - planeta karłowata - ma 
   szarą barwę, przez co jest mniej wyrazista.

   Oprócz położenie kątowego planety ukazano jej odległość od Ziemi. W położeniu bliskim maksymalnemu lub minimalnemu planeta dotyka koła orbitalnego odpowiednio od zewnątrz lub od wewnątrz.
   
   Planety ustawione są zgodnie z danymi astronomicznymi na określony dzień, w zakresie od 20 lutego 5401 p.n.e. do 
   20 lutego 5400 r. n.e. Uwzględnione jest położenie z północy czasu uniwersalnego.
   
   #### Podstawowe funkcje
   Pod głównym rysunkiem znajdują się suwak (_slider_) i dwa przyciski. Slider pozwala zmienić bieżącą datę (do 180 
   dni w przód i wstecz). Przycisk z napisem _Włącz obroty/Wyłącz obroty_ włącza i wyłącza tryb, w którym bieżąca 
   data zwiększa się o jeden dzień, a planety  aktualizują swoje położenie, co tworzy rodzaj animacji. Przycisk 
   _Podaj datę_ pozwala przejść do daty wpisanej w odpowiednim polu (w formacie ```dd.mm.yyyy```). Data bieżąca 
   ukazuje się w lewym górnym rogu rysunku głównego.
   
   Każda planeta może zostać przesunięta na swojej orbicie (wymaga to kliknięcia i przesunięcia myszą). Przestawienie
    w nowe położenie powoduje cofnięcie lub przesunięcie do przodu bieżącej daty, a w konsekwencji zmianę położenia 
    również innych planet. Towarzyszy temu odpowiedni komunikat, wyświetlany w prawym górnym rogu rysunku.
       
   #### Szczegóły techniczne
   W skład projektu wchodzi baza danych ```Efemerydy```, zawierająca tabele dla każdej planety oraz wykaz dat i 
   innych informacji pomocniczych. Baza ta łączy się z programem głównym, zawartym w pliku _main_circle.html_, za 
   pośrednictwem pliku _modifyPlanets.php_. Połączenie to, oparte na wzorcu **Active Record**, realizowane jest za 
   pomocą 
   funkcji ```
   .ajax```.  Położenie planet obsługiwane jest za pomocą klasy Planet, umieszczonej w pliku _Planet.php_, 
   wykorzystującej zmienną statyczną do przechowywania połączenia z bazą. Pozostałe 
   pliki zawierają funkcje dookreślające format tekstu oraz kod programów pomocniczych, testujących działanie 
   aplikacji oraz służących wprowadzeniu danych z wcześniej przygotowanych plików tekstowych.
   
   ## Uwagi końcowe
   Napisanie programu wymagało posłużenia się technikami obiektowymi (tworzenie klas w języku PHP oraz ich 
   odpowiedników w JavaScript) oraz łączenia się z bazą za pomocą ActiveRecord. Duże znaczenie miało wykorzystanie 
   funkcji trygonometrycznych do wyznaczania położenia punktu na okręgu oraz zastosowanie elementu _Canvas_ i 
   jego właściwości.
   
    
  Plik nie został poddany większej refaktoryzacji, zwłaszcza nie oddzielono plików testowych i pomocniczych od 
  programu głównego. Nie powoduje to jednak większych utrudnień, gdyż kod nie jest zbyt obszerny, a wszystkie funkcje
   programu wydają się łatwe do dostrzeżenia.
