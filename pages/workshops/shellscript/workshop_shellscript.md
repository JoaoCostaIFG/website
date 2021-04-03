class: middle, center

# Shell scripting workshop

A workshop by [João Costa](https://joaocosta.dev)

You can access the presentation here: [https://joaocosta.dev/workshop](https://joaocosta.dev/workshop)

---

class: middle, center

## Chapter 1 - Introduction

---

class: middle, left

### Why shell scripting

- Personal and professional automation purposes.
- Deepens knowledge of shell usage (linux servers).
- Quick and dirty.

---

class: middle, left

### The many shells

- We'll focus on staying POSIX compliant. This ensures compatibility with older
  systems/shells and better performance (Dash shell).
- Our code will work on almost every Linux shell (the main exception is FISH shell).
- We'll also talk about some Bash specific details because Bash is wildly
  used and builds on top of the POSIX standard.

---

class: middle, center

## Chapter 2 - Getting started

---

class: middle, left

### Development tools

- Most shell scripts are very simple, so we won't require many tools to get started.
- shellcheck: finds warnings/errors in scripts.
- checkbashisms: to find Bash specific snippets in scripts (POSIX compliance).

---

class: middle, left

### Running scripts and shebangs

To run a script, we first need to make it executable (`chmod +x <script>`).  
After that, we can call `./<script>`. This will run the script in your current shell.

We should always place a **shebang** on the first line of our scripts,
e.g.: `#!/bin/sh`. This indicates the shell where the script should be run.

You can also run a script by calling a shell on it, e.g.: `bash <script>`.

---

class: middle, center

## Chapter 3 - The basics

---

class: middle, left

### Everything is a string

In POSIX shell, everything can be seen as a **string**.  
This makes it very easy to work with various kinds of data, but it can
also prove to be a hindrance in some situations.

---

class: middle, left

### Variables

- Variables don't have a type.
- Variables don't need to be declared to be used.
- `name="John"` assigns the string **"John"** to the variable **name**.
  Notice that we can't use spaces around the **'='** sign.
- Variables are mutable. Their value can be changed by reassignment,
  e.g.: `name="Anthony"`.

To access the value of a variable, we prepped a dollar sign to the variable name,
e.g.: `other_name="${name}"`.  
We can print the value of a variable using a utility like echo: `echo $other_name`.

---

class: middle, left

### Notes about using variables

Notice this code snippet: `echo "${name}"`.

The curly braces, **'{}'**, around the variable name are unnecessary in most
circumstances, but can still be used has a safety measure,
e.g.: `b="$ac"` is different from `b="${a}c"`.

The **quotes** can be dropped in some situation, but it's recommended that you always
keep them. They prevent word splitting and shell globbing (we'll talk about these
later).

---

class: middle, left

### Pipes and Subshells

One of the biggest powers of shell scripts is their capacity to integrate
with your system's tools.

When we want to _capture_ the output of a command, we create a subshell. The
subshell is a separate process from the one we start with our scripts.

```bash
# This will read a file and get its first 11 lines, saving them on
# the file_content variable
file_content="$(cat file | sed 11q)"
echo "$file"
```

On the code above we see the usage of a pipe (**|**). Pipes allow us
to send the output of the command on the left into the input of the one
on right.  
We can even chain multiple pipes: `printf "1\n2\n3\n" | sed 2q | tail 1`.
This chain if commands will print the penultimate line of the file (**2**).

---

class: middle, center

## Chapter 4 - Arithmetic and output formatting

---

class: middle, left

### Arithmetic

Since everything is considered a string, the line `a=1+2` results in **"1+2"**.
To do arithmetic, we need to use **(( ))**.

In this case, we should have done `a="$((1 + 2))"`. We can also use variables
inside those parentheses. Their value will be interpreted as a number,
e.g.: `a="$((b + 2))"`.  
Notice that I didn't use the dollar sign for the variable **b**.

Doing arithmetic with variables containing non-numbers will result in an error.

---

class: middle, left

### Floating-point arithmetic

Most shells, including the POSIX standard and Bash, don't support
floating-point arithmetic natively. To do this, we need to use an external
tool like **awk**, **bc**, **maxima** or **python**.

Of these tools, the one you can almost always rely on being present are
**awk** and **python**.

To save the result of a division using python, we can:

```bash
result="$(echo "print(1/3)" | python)"
echo "$result"
```

or

```bash
result="$(python -c "print(1/3)")"
echo "$result"
```

---

class: middle, left

### Printf

Most Linux systems have the **printf** utility. This one should be familiar
to those who know C/C++.  
This utility allows us to format outputs in very complex ways, e.g.:

```bash
name="John"
surname="Johnson"
printf "- %s\n\t- %s" "$name" "$surname"

# Results in:
- John
  - Johnson
```

You can find a lot more information about **printf** in its man page,
`man printf`, and on various online tutorials.

---

class: middle, left

### Stream redirection

Every process has 3 main streams: stdin (**0**), stdout(**1**), stderr(**2**).
Input comes in through **stdin** and output goes through either **stdout**
(normal output) or **stderr** (error output).  
We can also create our own streams using file descriptors, but we'll not do
that here because that doesn't have many use cases. Just remember that
every open stream is associated with an unique integer called a
**file descriptor**.

Sometimes it's convenient to redirect this streams, e.g.:

- Send the output of a command to a file.

```bash
  # Redirecting stdin
  # note: the file 'numbers_file' will always be created if it doesn't exist

  # This will truncate the file contents before writting
  echo "123" > numbers_file

  # This will append to the file
  echo "123" > numbers_file
```

- Use the contents of a file as input for a command.

```bash
  # Redirecting stdout
  # note: this is an example and should be writte as: sed 4q file
  sed 4q < file
```

---

class: middle, left

### Common stderr redirections

In Unix/Linux systems you have access to a special file located
in **/dev/null**. Everything written to this file will be ignored/delete.

It's common to redirect the error stream to this file when we don't want
to see the error output of a script/command:

```bash
# Note the usage of the number 2 (meaning the second stream)
./script 2>/dev/null
```

Another common redirection is:

```bash
./script 2>&1 >log_file
```

This will redirect all the error messages (stderr) to the stdout (&1)
and then redirect **stdout** to a file. This way, we can send all outputs
to a single file.

---

class: middle, center

## Chapter 5 - Flow control

---

class: middle, left

### If statements

Conditional statements, also known as if statements are very powerful in shell
scripts.  
We can write if statements as so (pay attention to the spaces, they are very
important):

```bash
# This evaluates to True when string a is equal to string b
if [ "$a" = "$b" ]; then
  # do something..
else
  # do something else..
fi
```

Note: boolean values in shell are **true** and **false**.  
Note2: we can call `test` in an isolated fashion.

---

class: middle, left

### If statements cheat sheet

| If syntax                    | Meaning                           |
| :--------------------------- | :-------------------------------- |
| !                            | negate expression                 |
| -a                           | logical and                       |
| -o                           | logical or                        |
| -n STRING or STRING          | the length of STRING is nonzero   |
| -z STRING                    | the length of STRING is zero      |
| STRING1 = STRING2            | the strings are equal             |
| STRING1 != STRING2           | the strings aren't equal          |
| INT1 -eq INT2                | the integers are equal            |
| -ne, -ne, -gt, -ge, -le, -lt | other arithmetic comparison       |
| -d FILE                      | FILE exists and is a directory    |
| -e FILE                      | FILE exists                       |
| -f FILE                      | FILE exists and is a regular file |

You can learn more about if statements on `man test`.

---

class: middle, left

### Switch-case statement

We use this type of statements when we need to match a variable against
various different values.  
The list of values is searched from top to bottom and stops matching
after the first match.

```bash
case "$name" in
"Anna")
  # do something
  ;;
"John")
  # do something else
  ;;
"A"*)
  # This will match any name starting with an A
  ;;
*)
  # This will match any other name
  ;;
```

---

class: middle, left

### For loop

**For** loops allow us to iterate over a **range** or the elements of a
container/variable/directory.

To iterate over a range of [1, 10]:

```bash
for i in {1..10}; do
  # do something..
done
```

or over the elements in a variable:

```bash
for letter in $sentence; do
  # do something..
done
```

Note: you can also use C-like for loops  
`for ((i=0; i<10; i++)); do ...; done`

---

class: middle, left

### While loop

**While** loops allow us to repeat a block of code while a condition is
met. Usually, the conditions tested are same as the ones used in if statements:

```bash
while [ "$i" -eq 1 ]; do
  # do something
done
```

We can also redirect the input stream to **while** loops:

```bash
# This will read a file line by line:

while read -r line; do
  $echo "-${line}-"
done < "file_name"
```

We can also **pipe** input into **while** loops:

```bash
cat "file_name" |
while read -r line; do
  $echo "-${line}-"
done
```

---

class: middle, center

## Chapter 6 - Functions and special variables

---

class: middle, left

### Functions

The main purpose of functions is code organization. We can place code that is
repeated in multiple places inside a function and call it whenever we need.

```bash
# Functions can be defined in multiple ways but this one
# is the most common
say_hello_lucas() {
  echo "Hello Lucas! How are you doing?"
}

say_hello_lucas # This is a function call
```

We can also return values from functions. This values can only be integers
in the range \[0, 255\] (8bit).

---

class: middle, left

### Special variables

There are a number of special variables in our scripts. These variables can
only be read.

| Variable | Meaning                                                |
| :------- | :----------------------------------------------------- |
| $\*      | Positional parameters                                  |
| **$@**   | Positional parameters                                  |
| **$#**   | The number of positional parameters                    |
| **$?**   | The exit status of the most recently executed pipeline |
| $-       | The options flags of the current shell invocation      |
| $$       | PID of the shell                                       |
| $!       | PID of the most recent job places in the background    |
| $0       | Name of the current shell or shell script              |
| $\_      | Absolute path to the current invoked shell             |

Note: **Bold** means "most useful/commonly used".

---

class: middle, left

### Command line/Function arguments (Positional parameters)

When we call a script or a function, we can pass arguments to them. The
arguments are separated from each other by one or more spaces.

```bash
# This is script was called using: ./script a b

echo "$@" # prints "a b"
echo "$1" # prints "a"
echo "$2" # prints "b"

echo "$#" # prints "2"
```

When we're inside a function, the variables $0, $1, $2, and so on, take
the values of the arguments passed to the function (this also affects
**$# and $@**).

```bash
say_hello() {
  echo "Hello ${1}! How are you doing?"
}

say_hello "Lucas" # prints "Hello Lucas! How are you doing?"
say_hello "Carl" # prints "Hello Carl! How are you doing?"
```

---

class: middle, left

### Shift command

The shift command, `shift <n>` (if **n** is unspecified, it is assumed to be
1), shifts all positional parameters to the left.  
This means position parameter 1 will be assigned the value of parameter
**1 + n**, and so on.

```bash
# the script was called by: ./script 1 2 3
echo "$@" # 1 2 3
shift
echo "$@" # 2 3
```

Note: _shifting_ by a number larger than the number of positional parameters
you have left will yield an error.

---

class: middle, center

## Chapter 7 - Useful external tools

---

class: middle, left

### cat

The `cat <file1> <file2> ...` sends the contents of all given files to standard
output. It can be used to read a single file or to concatenate multiple files.

---

class: middle, left

### head and tail

The `head -n` and `tail -n N` commands get the first or last **N** lines (respectively)
from a given file/piped input.

Like most Unix utilities, these commands also have many flags to alter their
behavior. Here are some notable ones:

- If **-n** is not specified, it defaults to **N=10**.

- Using a negative **N** prints all but the last/first (for `head`/`tail`).

- Using **-c** instead of **-n** prints **N** bytes instead of lines.

---

class: middle, left

### cut

The `cut` command allows us to select parts of lines from files or piped
standard input.  
There are three main ways to use the `cut` command:

- Cutting by characters.

```bash
# This will print the first 3 characters of each line
cut -c 1,2,3 file
# Equivalent to
cut -c 1-3 file
# This will print from the second character to the last
cut -c 2- file
```

- Cutting by fields.

```bash
# We can define a limiter using '-d'
# And select which fields we want to print
# e.g.: print the first and third words of each line

cut -d " " -f 1,3 file
```

---

class: middle, left

## tr

The `tr` command allows us to translate and/or delete characters from ac given
stream (file/piped standard input).

```bash
# This will remove the new lines from the string
printf "1\n2\n3\n" | tr -d '\n'

# This will translate the number
# 1 to a, 2 to b and 3 to c
printf "1\n2\n3\n" | tr '123' 'abc'
```

---

class: middle, left

### POSIX Regex

I'll leave some notes I find useful when writing simple **regex**. Some of this
are POSIX specific, so they might not work outside the UNIX utilities.

| Symbol          | Meaning                  |
| :--------       | :----------------------- |
| ^               | Start of line            |
| $               | End of line              |
| [:alpha:]       | All letters (both cases) |
| [:digit:] or \d | Digits [0-9]             |
| [:space:] or \s | Blank characters         |
| .               | Any character            |
| *               | 0 or more times          |
| +               | 1 or more times          |
| ?               | 0 or 1 times             |
| {3}             | exactly 3 times          |
| {3,}            | exactly 3 or more times  |
| {3,5}           | exactly 3, 4 or 5 times  |

---

class: middle, left

### sed

The `sed` command is one of the most powerful Unix utilities. It is a stream
editor that uses its own scripting language.  
Given the extensibility of this topic, I'll only show you some basic/commonly
used `sed` commands.

```bash
# This command will replace the first occurences of
# 'wrld' with 'world!' in each line
echo "Hello wrld" | sed 's/wrld/world!/'
# We can use 'g' at the end of the command to
# replace all occurences
echo "Hello wrld" | sed 's/wrld/world!/g'

# This will remove all comments from a script
# and delete all blank/empty lines
sed 's/#.*//g; /^\s$/ d' script

# This will print the first 11 lines of a file
# q = quit after the script is done
sed '11q' file

# This will print line 1 to 4 of a file
# p = print matched lines
# -n means quiet (supress unmatched lines)
sed -n '1-4p' file
```

Note: `sed` accepts both files and piped inputs.

---

class: middle, left

### awk

`awk` is another very powerful utility with its own programming language. The
`awk` programming language specializes in text manipulation.

```bash
# This will print the second and last fields of
# the output of 'date'
# e.g.: Thu Oct 22 02:39:13 PM WEST 2020
date | awk '{print $2,$NF}'
# This will print the entire line
date | awk '{print $0}'

# We can change the field separator
echo "1-2-3" | awk -F'-' '{print $2}'

# Print all lines starting with an 'a'
awk '/^a/ {print $0}' file

# This will only print the lines where the third
# field is greater than or equal to 1000
awk '$3 >= 1000 {print $0} file'

# It also provides floating-point arithmetic
awk 'BEGIN {print sqrt(1 + 1)}'
```

---

class: middle, center

## Chapter 8 - Makefile

---

class: middle, left

### Why Makefiles

Originally, the main use of `make` was to list out a set of instructions to
compile C or C++ projects/files. This utility became quite powerful overtime
and I believe it is still underused for what it provides.

We'll cover `make` **without** focusing on program compilation.  
We can think of **Makefiles** as a very convenient way to define and run
certain functions called **targets**. The body of these 'functions' is called
a **rule**.

---

class: middle, left

### Basic Makefile and running make

Here is a very simple Makefile:

```make
# this is a target
world: hello
  @echo "world"

# this is another target
hello:
  # commands that aren't prefixed with '@' will be printed
  # out before their output
  echo "hello"
```

In this file, we have 2 targets: **world** and **hello**.

The line `world: hello` tells `make` that **world** depends on **hello**. This
means that when we call the target **world**, the target **hello** has to
be run first.

When we call `make` on a directory with the **Makefile** (the name is important!)
above, it will call the **world** target, because it is the first one defined
on the file (it is the same as calling `make world`).

---

class: middle, left

### Target files and the .PHONY variable

```make
# This is a variable
out_file = out

# depencies are processed in order
world: clean hello
  @printf "world!\n" >> $(out_file)

hello:
  @printf "hello " > $(out_file)

clean:
  @# This removes the specified file silently (no warnings)
  @rm -f $(out_file)

.PHONY: world hello clean
```

When a target is calling its dependencies, it will check if there is any
file in the current directory with the same name as the dependency. If there
is, the dependency will be skipped.  
This behavior will be overridden for all targets specified in the **.PHONY**
variable.

This behavior exists because it speeds up re-compilations when some files
fail compiling on the first attempt.

---

class: middle, left

### The all target

```make
all: one two three

one:
  echo "one" > one

two:
  echo "two" > two

three:
  echo "three" > three

clean:
  @rm -f one two three

.PHONY: all
```

With a target like this, we can run multiple default commands by calling `make`
without making them depend on each other.

---

class: middle, left

### Multiple targets for a rule

```make
all: one two three

# This rule will run for each of these targets names
one two three:
  @# The variable $@ contains the name of called target
  echo "$@" > "$@"

clean:
  @rm -f one two three

.PHONY: all
```

We can trim the duplicated code from the previous **Makefile** by making use
of the **$@** variable, the **all** target and sharing **rules** between
multiple targets.

---

class: middle, left

## Special thanks

- **Dylan Araps** for his work on the
  [Pura Bash Bible](https://github.com/dylanaraps/pure-bash-bible).
- **Vidar Holen** and the shellcheck community for their work and contributions
  to [shellcheck](https://github.com/koalaman/shellcheck) and its
  [wiki](https://github.com/koalaman/shellcheck/wiki).
- **IEEE UP Student Branch** for the opportunity to be here.

---

class: middle, center

## Thank you for listening

![Typing cat](gato.gif)

Download the presentation:  
[https://joaocosta.dev/static/files/shellscript.zip](https://joaocosta.dev/static/files/shellscript.zip)
