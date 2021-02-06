#!/bin/bash


DOMAINS=(center2m.com ipark45.ru ur.ite-ng.ru ite1.ite-ng.ru ite4.ite-ng.ru ite7.ite-ng.ru ite9.ite-ng.ru ite-mto.ru kpsz.ru kzkt45.ru nekeng.ru tm.ite-ng.ru center2m.ru ite11.ite-ng.ru ite2.ite-ng.ru ite6.ite-ng.ru ite8.ite-ng.ru ite-eg.ru ite-ng.ru kzet45.ru lazurnoe.net tts.ite-ng.ru )
FILE_RESULT=rejectedmails.txt
FILE_BUFF=buff
SEARCH='center2m';

echo > $FILE_RESULT

for val in $(ls | grep "reject") ; do 
echo $val
cat $val | grep $SEARCH -A 10 | grep -E -o "\\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,6}\\b"| sort | uniq >> $FILE_RESULT
done

#TEMP_A=buff.grep.a
#TEMP_B=buff.grep.b
#cp $FILE_RESULT $TEMP_A
NAMES=""
for NAME in "${DOMAINS[@]}" ; do
#    echo "cat $TEMP_A | grep -viE '$NAME' > $TEMP_B"
#    cat $TEMP_A | grep -viE '$NAME' > $TEMP_B
#    echo "cat $TEMP_B > $TEMP_A"
#    cat $TEMP_B > $TEMP_A
    NAMES="${NAMES}\@${NAME}|"
done
NAMES="${NAMES}${SEARCH}"
echo "cat $FILE_RESULT | grep -viE '${NAMES}' > s"
cat $FILE_RESULT | grep -viE "${NAMES}" > $FILE_BUFF
cat $FILE_BUFF | sort | uniq > $FILE_RESULT
rm -f $FILE_BUFF



