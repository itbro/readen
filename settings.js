// How many new rows are added to the Words after the button [+] is pressed
var newFieldsNum = 10;

// To highlight or not words after the button search is pressed:
// 0 = no
// 1 = yes
var redAtOnce = 1;

// What dictionary should be open for the pronunciation:
// 0 = none
// 1 = dictionary.cambridge.org
// 2 = oxfordlearnersdictionaries.com
// 3 = macmillandictionary.com
var dicPron = 1;

// The dictionary window height
var heightDic = 500;

// The gap between the top browser screen border and the Dictionary window
var topDic = 122;

var dark_color = "#E9E9E9";
var color_1 = "#868D8F";
// For the buttons ADD, EDIT, DELETE
var color_2 = "#AAA";
var color_3 = "#EEE";
var color_4 = "#FE5C72";
var color_5 = "#FFF";
// For the words without the translations
var color_6 = "rgb(255, 0, 0)";
// For the words with no translation
var color_red_value = " style='color:red;font-weight:bold;'";

// The vertical position of the Text interaction buttons
var top_down = 30;

// [Words]

// The number of the empty rows created by default
var words_num_rows = 30;

var param = 'width=600,height=500,scrollbars=1,top=149,left=200';

var add_above = "--";
var add_below = "==";
var del_this = "-=";
var del_empty = "=-";

// [Dictionary]

// What extra dictionary should be used if there is no word found in the Dictionary
// 0 = none
// 1 = academic
// 2 = multitran
// 3 = cambridge
// 4 = urbandictionary
// 5 = google
// 6 = yandex
// 7 = oxford
// 8 = macmillan
var searchEngine = 0;

// To clear or not the field "Source" in the Add new word form
// 0 = no
// 1 = yes
var clearSource = 0;

// Add automatically the source from the Add new word form
// to the field "Example" after the click on it
var add_source_if_clicked_option = 0;

// Add automatically the source from the Add new word form
// to the field "Source" after typing in the field "Example"
var add_source_when_typing_option = 1;

// What language the words selected must be
// to search for them in the Pronunciation (in the database)
var symbols_for_pron = "[a-zA-z]";

var pron_link_dic_by_default = "http://dictionary.cambridge.org/dictionary/english/";

// For transliteration from native language to foreign one
// for the function nativeToForeign()
var native_foreign = new Array();
native_foreign['№']='#';
native_foreign['ё']='\`';
native_foreign['й']='q';
native_foreign['ц']='w';
native_foreign['у']='e';
native_foreign['к']='r';
native_foreign['е']='t';
native_foreign['н']='y';
native_foreign['г']='u';
native_foreign['ш']='i';
native_foreign['щ']='o';
native_foreign['з']='p';
native_foreign['х']='[';
native_foreign['ъ']=']';
native_foreign['ф']='a';
native_foreign['ы']='s';
native_foreign['в']='d';
native_foreign['а']='f';
native_foreign['п']='g';
native_foreign['р']='h';
native_foreign['о']='j';
native_foreign['л']='k';
native_foreign['д']='l';
native_foreign['ж']=';';
native_foreign['э']='\'';
native_foreign['я']='z';
native_foreign['ч']='x';
native_foreign['с']='c';
native_foreign['м']='v';
native_foreign['и']='b';
native_foreign['т']='n';
native_foreign['ь']='m';
native_foreign['б']=',';
native_foreign['ю']='.';
native_foreign[',']=',';
native_foreign['Ё']='~';
native_foreign['Й']='Q';
native_foreign['Ц']='W';
native_foreign['У']='E';
native_foreign['К']='R';
native_foreign['Е']='T';
native_foreign['Н']='Y';
native_foreign['Г']='U';
native_foreign['Ш']='I';
native_foreign['Щ']='O';
native_foreign['З']='P';
native_foreign['Х']='{';
native_foreign['Ъ']='}';
native_foreign['Ф']='A';
native_foreign['Ы']='S';
native_foreign['В']='D';
native_foreign['А']='F';
native_foreign['П']='G';
native_foreign['Р']='H';
native_foreign['О']='J';
native_foreign['Л']='K';
native_foreign['Д']='L';
native_foreign['Ж']=':';
native_foreign['Э']='\"';
native_foreign['Я']='Z';
native_foreign['Ч']='X';
native_foreign['С']='C';
native_foreign['М']='V';
native_foreign['И']='B';
native_foreign['Т']='N';
native_foreign['Ь']='M';
native_foreign['Б']='<';
native_foreign['Ю']='>';

// For the transliteration from the foreign language to the native one
// for the function foreignToNative()
var foreign_native = new Array();
foreign_native['~']='Ё';
foreign_native['@']='\"';
foreign_native['#']='№';
foreign_native['$']=';';
foreign_native['^']=':';
foreign_native['&']='&';
foreign_native['\`']='ё';
foreign_native['q']='й';
foreign_native['w']='ц';
foreign_native['e']='у';
foreign_native['r']='к';
foreign_native['t']='е';
foreign_native['y']='н';
foreign_native['u']='г';
foreign_native['i']='ш';
foreign_native['o']='щ';
foreign_native['p']='з';
foreign_native['[']='х';
foreign_native[']']='ъ';
foreign_native['a']='ф';
foreign_native['s']='ы';
foreign_native['d']='в';
foreign_native['f']='а';
foreign_native['g']='п';
foreign_native['h']='р';
foreign_native['j']='о';
foreign_native['k']='л';
foreign_native['l']='д';
foreign_native[';']='ж';
foreign_native['\'']='э';
foreign_native['z']='я';
foreign_native['x']='ч';
foreign_native['c']='с';
foreign_native['v']='м';
foreign_native['b']='и';
foreign_native['n']='т';
foreign_native['m']='ь';
foreign_native[',']='б';
foreign_native['.']='ю';
foreign_native['/']='.';
foreign_native['Q']='Й';
foreign_native['W']='Ц';
foreign_native['E']='У';
foreign_native['R']='К';
foreign_native['T']='Е';
foreign_native['Y']='Н';
foreign_native['U']='Г';
foreign_native['I']='Ш';
foreign_native['O']='Щ';
foreign_native['P']='З';
foreign_native['{']='Х';
foreign_native['}']='Ъ';
foreign_native['A']='Ф';
foreign_native['S']='Ы';
foreign_native['D']='В';
foreign_native['F']='А';
foreign_native['G']='П';
foreign_native['H']='Р';
foreign_native['J']='О';
foreign_native['K']='Л';
foreign_native['L']='Д';
foreign_native[':']='Ж';
foreign_native['\"']='\"';
foreign_native['|']='/';
foreign_native['Z']='Я';
foreign_native['X']='Ч';
foreign_native['C']='С';
foreign_native['V']='М';
foreign_native['B']='И';
foreign_native['N']='Т';
foreign_native['M']='Ь';
foreign_native['<']='Б';
foreign_native['>']='Ю';
foreign_native['?']='?';

// Extra replacements for the function nativeToForeign()
var nativeToForeign_Shift_from_1 = "\"\"\"", nativeToForeign_Shift_to_1 = "@";
var nativeToForeign_Shift_from_2 = "###", nativeToForeign_Shift_to_2 = "№";
var nativeToForeign_Shift_from_3 = ";;;", nativeToForeign_Shift_to_3 = "$";
var nativeToForeign_Shift_from_4 = ":::", nativeToForeign_Shift_to_4 = "^";
var nativeToForeign_Shift_from_5 = "???", nativeToForeign_Shift_to_5 = "&";
var nativeToForeign_Shift_from_6 = "///", nativeToForeign_Shift_to_6 = "|";

// Extra replacements for the function foreignToNative()
var foreignToNative_Shift_from_1 = "ююю", foreignToNative_Shift_to_1 = ".";
var foreignToNative_Shift_from_2 = ",??", foreignToNative_Shift_to_2 = "?";
var foreignToNative_Shift_from_3 = "Э\"\"", foreignToNative_Shift_to_3 = "\"";
var foreignToNative_Shift_from_4 = "жжж", foreignToNative_Shift_to_4 = ";";
var foreignToNative_Shift_from_5 = "ЖЖЖ", foreignToNative_Shift_to_5 = ":";
var foreignToNative_Shift_from_6 = "....", foreignToNative_Shift_to_6 = "/ ";
