# BASH STUFF
.bash_profile(located in home in linux) is a hidden file that changes the terminale proprieties. to make correctly loaded the changes we must use
source .bash_profile
we can create some alias for commands (alias ll="ls -la"), make variables (export USER="Francesco"), change style of the cmd(export PS1=">> " this change the $ in the cmd with >>).
    $PATH contains all directories where scripts are stored.
    most of command are stored in bin(u can check this by using /bin/"command").
    grep filter with some string we put in(can be recursive).

# REDIRECT OUTPUTS
basic:
    echo "hello">hello.txt  (overwrite)
    echo "hello">>hello.txt (do not overwrite)
    #in less words, the output goes where teh </> is directed
    wc(worc count) prodice line count, word count and byte count
    sed(stream editor) "s(substitution)/snow(string searched)/rain(string replace with) file.txt" with -i it will make changes, if not specified it will only display but not changing.