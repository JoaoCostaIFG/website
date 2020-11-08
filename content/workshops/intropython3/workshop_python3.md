name: slide_title  
class: slide_title, center, middle  
layout: true
{{content}}
---
name: slide_contents
class: slide_contents
layout: true
{{content}}
---
name: slide_section  
class: slide_section, center, middle
layout: true
{{content}}
---
name: slide_normal
class: slide_normal, left, top
layout: true
{{content}}
---
template: slide_title
# Workshop Introduction to Python 3

<div class="slide_logos">
<img alt="nuieee-logo" src="assets/nuieee-logo.png">
<img alt="cs-logo" src="assets/computer-society-logo.svg">
</div>

---
template: slide_contents
# Contents
1. [Interpreter](#interpreter)
1. [Variables](#variables)
1. [Data Types](#data_types)
1. [Flow Control](#flow_control)
1. [Data Structures](#data_structures)
1. [Iteration](#iteration)
1. [Functions](#functions)
1. [Comprehensions and Generators](#comprehensions_and_generators)
1. [Modules](#modules)
---
template: slide_section
name: interpreter

# Interpreter

---

template: slide_normal
## REPL
The **REPL** (Read Evaluate Print Loop) runs on a command line and can be called through `python`.  
*Warning:* As python is a language where tabs have meaning, extra spaces or tabs before the input will result in an error.
```py
Python 3.7.4 (tags/v3.7.4:e09359112e, Jul  8 2019, 19:29:22) [MSC v.1916 64 bit (AMD64)] on win32
Type "help", "copyright", "credits" or "license" for more information.
>>> print("Hello World")
Hello World
```

To exit the REPL type **quit()**. Certain OS specific keybinds also work, in windows Ctrl+Z and in Unix Ctrl+D. 

???

REPL: It loops while awaiting for an input, interpreting it and printing its result.  
Multilne: New line and keep writing (symbol changes from `>>>` to `...`).  
Comments:'#'.  
Brincar com o REPL.  

---

## Useful REPL Functions:

## dir

This funcion returns the attributes of an object.  
For example, to know all the attributes of a string:

```py
>>> dir("anyString")  # or dir(str)
['__add__', '__class__', '__contains__', '__delattr__', '__dir__', '__doc__', '__eq__', '__format__', '__ge__', '__getattribute__', '__getitem__', '__getnewargs__', '__gt__', '__hash__', '__init__', '__init_subclass__', '__iter__', '__le__', '__len__', '__lt__', '__mod__', '__mul__', '__ne__', '__new__', '__reduce__', '__reduce_ex__', '__repr__', '__rmod__', '__rmul__', '__setattr__', '__sizeof__', '__str__', '__subclasshook__', 'capitalize', 'casefold', 'center', 'count', 'encode', 'endswith', 'expandtabs', 'find', 'format', 'format_map', 'index', 'isalnum', 'isalpha', 'isascii', 'isdecimal', 'isdigit', 'isidentifier', 'islower', 'isnumeric', 'isprintable', 'isspace', 'istitle', 'isupper', 'join', 'ljust', 'lower', 'lstrip', 'maketrans', 'partition', 'replace', 'rfind', 'rindex', 'rjust', 'rpartition', 'rsplit', 'rstrip', 'split', 'splitlines', 'startswith', 'strip', 'swapcase', 'title', 'translate', 'upper', 'zfill']
```

This function can help you get all the attributes when your IDE doesn't show it or when you don't have access to the internet.

---

## help

Documentation built-in python itself!
Calling `help()` without arguments will bring up an interactive menu (*tip:* experiment calling it from the REPL) 

Calling `help()` with an argument will give that argument's documentation:  
- With a **variable** in the argument it will assume its datatype as the argument; 
- With `int`, `str` or `float`, it will yield information about the data types;  
- With a **class**, **function** or **method**, it will yield even more information (*see next slide*).  

**Note**: In windows, sometimes too much information will show up, if you want to stop the help function in the REPL simply type Ctrl+C to stop it.  
---

## Calling help() with a method

```py
>>> help(str.split)
Help on method_descriptor:

split(self, /, sep=None, maxsplit=-1)
    Return a list of the words in the string, using sep as the delimiter string.

    sep
      The delimiter according which to split the string.
      None (the default value) means split according to any whitespace,
      and discard empty strings from the result.
    maxsplit
      Maximum number of splits to do.
      -1 (the default value) means no limit.
```


---
template: slide_section
name: variables
# Variables

---

template: slide_normal
## Variables as Objects

In Python all variables point to objects with 3 parts: id, value and type. 
 
As variables are light, reusing them doesn't really improve memory usage. We recommend you keep your variable types consistent to avoid confusing code.

<p align="center">
    <img src="assets/variables-objects.png" alt="Relationship between variables and objects" width="auto" height="250px">
</p>

---

## Garbage Collection

The explanation for the reassigned objects being deleted is that every object has a reference count, the number of times it is referenced. This number is always positive and once it reaches zero, the garbage collector is called to free the memory used by that object, efectively making it disappear. If you ever wish to know this reference count use the following code:

```py
>>> import sys
>>> name = "IEEE"
>>> sys.getrefcount(name)
2
```

Please note that, as the documentation says, the reference count returned is generally one higher than you might expect, because it includes the (temporary) reference as an argument to getrefcount().

???
IMUTÁVEL:
Ao alterar um objeto, ele ficará a apontar para um novo objeto ou para outro já existente
MUTÁVEL:
Altera o objeto em si
---

## Variable Naming

Python enforces that a ***variable should never have the name of a keyword or start with numbers***, doing so will result in a syntax error:
```py
>>> if = "if"
  File "<stdin>", line 1
    if = "if"
       ^
SyntaxError: invalid syntax
```

**Note**: For a list of all keywords that will produce a syntax error:
```py
>>> import keyword
>>> print(keyword.kwlist)
['False', 'None', 'True', 'and', 'as', 'assert', 'async', 'await', 'break', 'class', 'continue', 'def', 'del', 'elif', 'else', 'except', 'finally', 'for', 'from', 'global', 'if', 'import', 'in', 'is', 'lambda', 'nonlocal', 'not', 'or', 'pass', 'raise', 'return', 'try', 'while', 'with', 'yield']
```

---

## Variable Naming

Other naming conventions are not mandatory, but are considered good practice:
- Separate words in variable names either with underscores (big_variable) or with capital letters (bigVariable). Use only one of these throughout your code.
- Don't override built-ins.

Although built-in words could be used for a variable, doing this will not allow you to access them again and is considered a bad practice. The only way to use that built-in word again is through the `__builtins__` module.  
Many can be used by accident, such as **dict**, **id**, **list**, **min**, **max** or **str**.

**Note**: For a list of all built-ins that you should avoid:
```py
>>> dir(__builtins__)
['ArithmeticError', 'AssertionError', 'AttributeError', 'BaseException', 'BlockingIOError', 'BrokenPipeError', 'BufferError', 'BytesWarning', 'ChildProcessError', 'ConnectionAbortedError', 'ConnectionError', 'ConnectionRefusedError', 'ConnectionResetError', 'DeprecationWarning', 'EOFError', 'Ellipsis', 'EnvironmentError', 'Exception', 'False', 'FileExistsError', 'FileNotFoundError', 'FloatingPointError', 'FutureWarning', 'GeneratorExit', 'IOError', 'ImportError', 'ImportWarning', 'IndentationError', 'IndexError', 'InterruptedError', 'IsADirectoryError', 'KeyError', 'KeyboardInterrupt', 'LookupError', 'MemoryError', 'ModuleNotFoundError', 'NameError', 'None', 'NotADirectoryError', 'NotImplemented', 'NotImplementedError', 'OSError', 'OverflowError', 'PendingDeprecationWarning', 'PermissionError', 'ProcessLookupError', 'RecursionError', 'ReferenceError', 'ResourceWarning', 'RuntimeError', 'RuntimeWarning', 'StopAsyncIteration', 'StopIteration', 'SyntaxError', 'SyntaxWarning', 'SystemError', 'SystemExit', 'TabError', 'TimeoutError', 'True', 'TypeError', 'UnboundLocalError', 'UnicodeDecodeError', 'UnicodeEncodeError', 'UnicodeError', 'UnicodeTranslateError', 'UnicodeWarning', 'UserWarning', 'ValueError', 'Warning', 'WindowsError', 'ZeroDivisionError', '_', '__build_class__', '__debug__', '__doc__', '__import__', '__loader__', '__name__', '__package__', '__spec__', 'abs', 'all', 'any', 'ascii', 'bin', 'bool', 'breakpoint', 'bytearray', 'bytes', 'callable', 'chr', 'classmethod', 'compile', 'complex', 'copyright', 'credits', 'delattr', 'dict', 'dir', 'divmod', 'enumerate', 'eval', 'exec', 'exit', 'filter', 'float', 'format', 'frozenset', 'getattr', 'globals', 'hasattr', 'hash', 'help', 'hex', 'id', 'input', 'int', 'isinstance', 'issubclass', 'iter', 'len', 'license', 'list', 'locals', 'map', 'max', 'memoryview', 'min', 'next', 'object', 'oct', 'open', 'ord', 'pow', 'print', 'property', 'quit', 'range', 'repr', 'reversed', 'round', 'set', 'setattr', 'slice', 'sorted', 'staticmethod', 'str', 'sum', 'super', 'tuple', 'type', 'vars', 'zip']
```
---
template: slide_section
name: data_types
# Data Types

---

template: slide_normal
## Variables and Data Types - Concept

***Variables*** and ***data types*** are the building blocks of all programs.

In order to better manipulate them, two concepts must be taken into consideration:

+ **State**: The current *status* of a data type.
    True or False; 1, 2, 1000; 1.4, 1.2, etc ...
+ **Mutation**: The process of altering the *state* of a data type.

Then, we can define:

+ **Data type**: A way in which data can be arranged.
    When creating a new data type a "copy" of it is created
    (an ***object***) in memory.
     Some are ***mutable*** (are sucseptible to change) where as others are ***immutable***.
     Ex: boolean, integer, string, etc ...

???

int == conjunto dos numeros inteiros
floats == conjunto dos numeros reais

---

## Numbers

In general there are two types of representing numbers: ***integers*** and ***floats***.
You can create these variables easily in the interpreter:

```python
a=3   # integer
b=4.0 # float
```

|*Operation* | *Symbol* |
|:-|:-:|
|Addition            |          + |
|Subtraction         |          - |
|Multiplication      |          * |
|Division            |          / |
|Integer Division    |          // |
|Remainder           |          % |
|Power               |          ** |

???

Mostrar q 2e5 funciona
Mostrar q += e amigos existem

---

## Numbers

Some notes to take into account:

+ When dividing two numbers the result is a *float*.
+ When using operators between *integers* the result is an *integer*
    (except for division).
+ When using operators between *floats* the result is a *float*.
+ When using operators between *floats* and integers the result is a *float*.

  ```python
  print(3.0 * 2) # 6.0
  print(1 / 1) # 1.0
  ```

+ Python takes operation priority into account
   (parenthesis are the highest priority, then \*\*, etc...)

---

## Booleans

The ***boolean*** type is used to store values for ***True*** or ***False***.
Some variables can be converted to boolean by using:

```python
bool("") # False (empty string)
bool("qwerty") # True
```

In general, an object that is considered to be empty (Ex: "", [  ], 0)
returns false, while an object that contains anything returns true (Ex: 5, 0.1).

True          | False
--------------|----------------
True          | False
"0"           | ""
[1, 2, "asd"] | [  ]
{4}           | {}
4             | 0
0.01          | 0.0

---

## Strings

The ***string*** data type stores text or a sequence of characters. We can define
them by surrounding text by ', " or """.

```python
a="this is a string"
```

To define a quote inside a string, so as to not confuse the python interpreter,
a escape sequence \" can be used.

```python
print("\"This is a quote\"")
```

???

Mencionar operadores (tipo o +) entre strings

---

## Escape Sequences

| **Output** | **Escape Sequence** |
| :- | :-: |
| Backslash | \\\\ |
| Newline / Paragraph | \\n |
| Double quote | \\" |
| Single quote | \\' |
| Unicode character | \\Uxxxx |
| Octal character | \\o87 |
| Hexadecimal character | \\xFA |

---

## String Indexing

By convention, the indexing of the characters in a string starts at 0.  

<p align="center">
    <img src="assets/slicing.png" alt="List Indexing (Bird, Steven, Edward Loper and Ewan Klein (2009), Natural Language Processing with Python. O’Reilly Media Inc.)" width="auto" height="200px"/>
</p>

---

## String Indexing

You can use indexing to:

+ Access the nth character of a string using __**str[n]**__.
+ Retrieve the last character of a string by __**str[-1]**__.
+ Access the nth last character with __**str[-n]**__.
+ Inverse the string with __**str[::-1]**__.

```python
a="IEEE"
print(a[0])   # "I"
print(a[-2]   # "E")
print(a[::-1] # EEEI)
```

---

## String Slicing

Indexing also allows string slicing. Slicing returns a substring of the string that we are slicing.

To specify the starting and ending indexes of the substring we use the following syntax: ***str[start:end]***.

```python
my_str="A beautiful morning"
my_substr=my_str[2:11]
print(my_substr) # beautiful
print("A beautiful morning"[12:]) # morning
print("A beautiful morning"[:12]) # A beautiful
```

+ If we ommit the starting index, the substring will be made from the beggining of the original string.
+ If we ommit the ending index, the substring will be made to the end of the original string.
???

Explain a inclusidade: 1o int é inclusivo, 2o é exclusivo.
O que acham que my_str[:] vai dar retreive

---

## String Methods

One particularity of strings is that they are ***immutable***,
and as such, cannot be changed. 

```python
a="str"
a[0]="t" # ILLEGAL! - str object does not support assignment
```

As a consequence, when trying to change the content of a
string we are forced to create a new one.

Therefore, all methods of the str class will always return a new string
and will **never** modify an existing one.

---

## String Methods

To call a string method we use the syntax: **string_variable**.***method***(*args*).

Some methods may require a number of arguments (which may be mandatory, depending on the method).

We won't cover all string methods due to time constraints, but keep in mind that the command
***help(__method__)*** or the [***official documentation***](https://docs.python.org/3/index.html)
both have extensive information on how to use all methods of the library.

The following list contains the most common string methods.

+ ***str.capitalize()*** - Makes first character upper case and the rest lower.

    ```python
    "ferNANdo caRVALho".capitalize() # Fernando carvalho
    ```

???

Vamos dar so um cheirinho de todos os metodos.
Explicar [:] de como era um arg optional.

---

## String Methods

+ ***str.count(sub[, start[, end]])*** - Return the number of non-overlapping
  occurrences of substring sub in the range [start, end].
  Optional arguments start and end are interpreted as in slice notation.

  ```python
  "ananas".count("an") # 2
  "ananas".count("an", 2) # 1
  ```

+ ***str.join(iter)*** - Concatenates str between every member of iter.

    ```python
    ", ".join("123") # "1, 2, 3"
    "_".join(["1", "2", "3"]) # 1_2_3
    ```

???

The last example is a list, which we will discuss later.

---

## String Methods

+ ***str.find(sub[, start[, end]])*** - Return the lowest index in the string where
    substring sub is found within the slice s[start:end]. Optional arguments start
    and end are interpreted as in slice notation. Return -1 if sub is not found.

    ```python
    "Dory_Nemo".find("Nemo") # 5
    ```

    **Note:** Don't use when trying to check if sub is a substring. Use the in operator
    (much more efficient)

    ```python
    "Nemo" in "Dory_Nemo" # True
    ```

+ ***str.lower()*** - Return a copy of the string with all the cased characters
    converted to lowercase.

    ```python
    "FeRNaNDo".lower() # "fernando"
    ```

---

## String Methods

+ ***str.replace(old, new[, count])*** - Return a copy of the string with all
    occurrences of substring old replaced by new. If the optional argument
    count is given, only the first count occurrences are replaced.

    ```python
    "I3E".replace("3", "EE") # IEEE
    "IEEE".replace("E", "_", 2) # I__E
    ```

+ ***str.split()*** - Return a **list** of the words in the string, using sep
    as the delimiter string. If maxsplit is given, at most maxsplit splits are done

    ```python
    "1, 2, 3".split(", ") # ["1", "2", "3"]
    "1,2,3".split(',', maxsplit=1) # ["1", "2,3"]
    ```

---

## Format Method

The ***format*** formats strings that are identified with the {} (braces) placeholder.
All placeholders will be replaced by the arguments given in the .format call.

The type of formatting can be specified in the arguments of the method.

```python
name="Fernando"
print("My name is {}".format(name)) # "My name is Fernando"
```

It is possible to specify the order in which the strings are substitute
by inserting an integer into the braces.

```python
print("1st:{3};2nd:{0};3rd:{1};4th:{2}".format("Second", "Third", "Forth", "First"))
# 1st:First;2nd:Second;3rd:Third;4th:Forth
```

---

## Format Method

There is a whole portefolio of different options that can be used with format.

```python
print("{:>30}".format("IEEE")) # Right with 30 width
#                IEEE

print("{:b}\n{:x}\n{:X}\n".format(8, 13, 13)) # Binary or Hexa notation
# 1000
# d
# D
print("{:.3e}\n{:.2g}\n{:%}".format(3.14, 1.26, 0.666)) # Exponent
# 3.140e00
# 1.3
# 66.600000%
```

Make sure to check the wiki for a brief summary or the official docs for a more extensive explanation.

???
Time constrains, xau nao vamos falar mt
Dizer o que o width representa quando usamos o format (linha onde o fim de todas as strings vai estar)

---
template: slide_section
name: flow_control
# Flow Control

---

template: slide_normal
## Flow Control Tools
  
Up until now, all the code we've written was executed in **top-down order**. Sometimes it's necessary to change the way a program flows, for example, making a program that can decide weather or not to run a piece of code.

In Python, we have 3 flow control structures:  
1. [If statement](#if)  
1. [For loop](#for)  
1. [While loop](#while)  

---
name: if
## If

- **If** statements are **Python's** decision making structure.
- The decisions are made by checking the **truth value** of a condition.
- The blocks of code that are inside an **If** structure are only run if the condition is **True**.

Usually **If** structures are followed by an optional **Else** clause. The code inside the **Else** clause is only run if the condition in its corresponding **If** structure was **False**.

```python
a = 1
b = 2
if a == b:
    print("Equal")
elif a > b:
    print("a > b")
else: print("a < b")

```
---

#### If Cheat Table

| Operator | Meaning |
|:-:|:-|
| == | equality test |
| != | inequality test |
| > | greater than |
| < | less than |
| >= | greater than or equal to |
| <= | less than or equal to |
| and | logical and |
| or | logical or |
| not | logical not |
| True | logical true |
| False | logical false |

???

equality != from attribution
:= can do both at the same time from Python 3.8 onwards

---

name: for
## For

The **For** loop is one of the two loops available in **Python**. We use this loop when we want to repeat a code block a known, finite, number of times.  
The **For** loop makes heavy use of the **range** object.

- A **range** is defined as follows: `range(start, [end, [step]])`.
- The interval is closed on the left side and open on the right side [start, end).
- The **step** parameter is optional and by default is 1.
- We can also create **range** objects with only 1 parameter: `range(3)`. These are the same as: `range(0, 3)`.

---

## For

The **For** loop can be followed by an **Else** clause. The block of code inside the **Else** clause is executed once after the **For** loop is over, unless we reach a **break** keyword inside the **For** loop.

Another structure of a **For** loop will be presented in [Iteration](#iteration).

### Example

```python
for i in range(3):
    print(i)
    break
else
    print("Else clause")
```

---

name: while
## While

**While** is the second and last available loop in **Python**. We use this loop when we want to repeat a code for an unknown amount of times (while a condition is **True**).

### Example
```python
a, b = 0, 5
while(a < b):
    print(a)
    a += 1
```
---
template: slide_section
name: data_structures
# Data Structures

---

template: slide_normal
## Intro
Variables have already shown to be extremely useful in many situations but sometimes they are not enough. We'll now talk about Python's standard data structures and show how/why they can be useful in many situations.

In Python, we have 4 standard data structures:  
1. [Lists](#lists)  
1. [Tuples](#tuples)  
1. [Sets](#sets)  
1. [Dictionaries](#dictionaries)  

---

name: lists
## Lists

A **List** is an **ordered**, **mutable** sequence of elements. Each element inside a **List** is called an **item**.  
- The **items** are indexed by an integer starting on 0.  
- In Python, the **items** are also be indexed by a negative integer that starts in -1 on the last item of the **List**.    
- You can cast iterable objects to the **List** type using: `alist = list(iterable)`

<p align="center">
   <img src="assets/slicing.png" alt="List Indexing (Bird, Steven, Edward Loper and Ewan Klein (2009), Natural Language Processing with Python. O’Reilly Media Inc.)" width="auto" height="200px"/>
</p>

???

Ordered, mutable

---

### Examples

```python
# Declare a list with the items 1, 2
alist = [1, 2]

# Appends an element to the end of the list
alist.append(5)

# Appends all the elements in an iterable to 'alist'
anotherlist = [3, 4]
alist.extend(anotherlist)

# Inserts an item, x, at a given position, i, in a list (list.insert(i,x))
alist.insert(1, 9)

# Removes the first item from the list with value x (list.remove(x))
alist.remove(9)
```

---

### Examples

```py
# Remove and return an item from a list at a given position, i
# If no argument is given, remove and return the last element from the list
alist.pop(1)

# Return the index of the first item with value x in the list
# Can take an option start and/or end index (list.index(x[, start[, end]]))
print("Index:", alist.index(1))

# Count the number of times an item, x, appears in the list
print("Number of occurrences", alist.count(1))

# Reverses the items of the list, in place
alist.reverse()

# remove all items from a list (equivalent to del alist[:])
blist.clear()
```

---

### Example

```py
# blist is a pointer to alist
blist = alist
# blist is a shallow copy of alist (doesn't 'shallow copy' recursively)
blist = alist.copy()
# blist is a deep copy of alist (copies recursively)
from copy import deepcopy
blist = deepcopy(alist)
```

In a shallow copy, it would not copy the inner data structures (only a reference), in a deep copy it would copy the data structure.

As you might have noticed, **Strings** and **Lists** have many common properties, like indexing and slicing operations. They are both examples of sequence data types.  
Methods that only modify the **List** have return value **None**. This is a design principle for all **mutable** data structures in **Python**.  

???

modify list -> return type None (all mutable data structures)

---

### The del statement

- We can use the **del** statement to remove an item from a list given its index.  
- The **del** statement differs from **pop()** because it doesn't return a value.  
- The **del** statement can also be used to remove **slices** of items from a list (including clearing the whole list).  

```python
alist = [1, 2, 3, 4, 5, 6, 7, 8]

# Remove 1 element
del alist[1]

# Remove a slice
del alist[0:3]

# Remove all elements (same as alist.clear())
del alist[:]
```
---

name: tuples
## Tuples

**Tuples** are another of **Python's** standard sequence data types. They are an **ordered**, **immutable** data structure.  
- The indexing starts at 0.  
- **Tuples** can, and usually, contain elements of any type and of different types (heterogeneous elements).  
- **Tuples** can be nested.  
- If a **Tuple** contains an **mutable** object, we can still change the objects value which in turn 'changes' the **Tuple**.   
- You can cast iterable objects to the **Tuple** type using: `atuple = tuple(iterable)`
- The paratheses are not mandatory in most declarations but we recommend their use either way

---

### Example

```python
atuple = (1, 2, 'hey', 4.2, 0)

# Elements are indexed
print("1st element of out tuple", atuple[0])

# Nested tuples
btuple = ("a", atuple, 96, atuple)
print(btuple)

# Since tuples are immutable, this next line results in an error
# atuple[1] = 3

# But you can alter a mutable object inside the tuple
alist = [1, 2, 3]
ctuple = (alist, 4, 5)
ctuple[0][0] = 3
```

---

### Special Tuples

Sometimes, we may find ourselves in need of creating a **Tuple** with 1 or 0 elements. To do this, we need to use a slightly more confusing syntax.

```python
# Declare an empty tuple
emptytuple = ()

# Declare a tuple with only 1 element
singletuple = (1, )  # Notice the trailing comma

print("Our tuples:", emptytuple, singletuple)

print("emptytuple's len:", len(emptytuple))
print("singletuple:", len(singletuple))
```

---

### Sequence Unpacking

We can use **Tuples** to pack/unpack sequences. Sequence unpacking requires us to give the same number of variables on the left side of the equal sign as elements inside the **Tuple**.

```python
# Tuple packing
atuple = (1, "hey", 123412.32)
print("Our tuple", atuple)

# Sequence unpacking (paretheses are also optional here)
(x, y, z) = atuple
print("Our varibles:", x, y, z)
```

---

name: sets
## Sets

**Sets** are **unordered** **mutable** collections of elements with **no duplicates**. Basic uses include membership testing and eliminating duplicate entries.  
Mathematical operations like union, intersection, difference, and symmetric difference.  
- **Sets'** elements aren't indexed and we can't rely on them being in any specific order.  
- To create a **Set**, we can use curly braces or the `set()` function. We should note that we can't do: `emptyset = {}` in order to create an empty set, as this would create an empty **[Dictionary](#dictionaries)**. To create an empty **Set**, we use: `emptyset = set()`.  
- The `set()` function can also be used to cast an iterable to the **Set** type: `aset = set(iterable)`.  

???

Unsorted and mutable

---

### Examples

```python
# Declare a set
aset = {"yum", "sweet", "potato", "yum"}
# Equivalent to aset = set(['yum', 'sweet', 'potato'])
print("Our set:", aset)

# Check membership
# This in keyword will be discussed in detail in the chapter Iteration
# For now, we just need to know that it checks if "yum"
# is equal to at least 1 of the elements of aset
print("yum" in aset)
print("Iargo" in aset)
```

---

### Examples

```py
# Crating sets from an iterable (string)
x = set("comparable")
y = set("complementary")

# Unique letters
print("Unique letters in x:", x)

# Difference
print("Letters in x but nor in y:", x - y)

# Union (Or)
print("Letters in x, y or both:", x | y)

# Intersection (And)
print("Letter in both x and y:", x & y)

# Symmetric difference (Xor)
print("Letters in x or y but not in both:", x ^ y)
```

---

name: dictionaries
## Dictionaries

The biggest difference between a sequence data type, like **[Lists](#lists)** or **[Tuples](#tuples)**, and **Dictionaries** is that Dictionaries are indexed by **keys**.  
- **Keys** can be of any **immutable** type. **Strings** and **numbers** can always be keys.  
- **[Tuples](#tuples)** can be used as **keys** if they only contain immutable objects.  

**Dictionaries** store **key:value** pairs. We can't have duplicated **keys** but we can have 2 different **keys** associated with the same **value**.  
**Dictionaries** can be declared using {} or using the dict() function (by casting a nested iterable).  

---

### Examples

```python
# Equivalent to ages = dict([[Carlos, 12], [Vilas, 19], [Tiago, 5]])
# Or ages = dict(Carlos=12, Vilas=19, Tiago=5) (simple string keys)
ages = {"Carlos": 12, "Vilas": 19, "Tiago": 5}

# Print a single element
print("Tiago's age:", ages["Tiago"])

# We can add any key:value pair to dictionary at any time
ages[432.5] = "oops"

# The list() funtion will return a list of the keys in the dictionary
# in insertion order
print("Our keys list:", list(ages))

# The values() method will return an object of type dict_values
print("Our values list:", list(ages.values()))
```

---

### Examples

```py
# A dictionary is also an iterable (will be discussed later)
print("Carlos" in ages)

# The next commented line results in an error because 
# we can't access non-existant keys
# print(ages["123"])

# If we store a key that's already in use, the previous
# value of that key is dropped
ages["Carlos"] = 11
print("Our dict:", ages)

# We can use the del keyword with dictionaries
del ages["Vilas"]
print("Our dict:", ages)
```

---
template: slide_section
name: iteration
# Iteration

---

template: slide_normal
## 'Iteration'?

When you previously used a `for` cycle, you would write `for i in range(5)` to ***iterate*** the numbers 0 through 4. This is because the `in` keyword allows you to cycle through all elements of a data structure. For example, if you cast the previous range object, you would obtain the following list:

```python
print(list(range(0, 5)))
# [0, 1, 2, 3, 4]
```

### Definition:

- **Iterable**: An object you can loop over.

- **Iterator**: An object that represents a **data stream** that handles **iterating** over an iterable.

---

## The 'in' keyword

This allows you to iterate through any object that is classified as an `Iterable`, such as **lists**, **tuples**, **dictionaries**, **sets**, **strings** and **file objects** if used, for example, in a for loop. You can even iterate through an Iterable object of another iterator:

```python
alist = ["One", "Two"]
for item in alist:
    for letter in item:
        print(letter, end=' ')
    print()
 
# O n e
# T w o
```

As such, you can see that Python's `for` loop behaves more like a `for each` rather than a traditional for loop. 

---

## The 'in' keyword

You can check for the **existance** of an element in a data structure:

```python
# Checking for elements in a dictionary
adict = {"Tiago": 19, "Costa": 18, "Lucas": 21}
print("Is Lucas in adict:", "Lucas" in adict) # True
print("Is Fábio in adict:", "Fábio" in adict) # False
print("Is there anyone 21 years old:", 21 in adict.values()) # True
print("Is there anyone 39 years old:", 39 in adict.values()) # False
```

This method of iteration even works with other modules data structures, such as pandas' Dataframes or numpy's Arrays.

---

## Iterators are lazy

A great advantage of iterators is they only do their job when it's actually needed. This is, if you would need to access only 3 out of 500 elementes of, for example, a list, python's iterable would only load the first 3 instead of loading all 500 elements automatically.

 This means that you could, theoretically, deal with *infinitely* large data structures because the iterable would only care about an element at a time, saving both **memory** and **CPU time**.

---

## Iterators are everywhere!

There are a lot of handy functions in Python whose implementaion relies heavily on iteration, from which some of the more noticeable are:

- `reversed()`:  
Iterates through an iterable from the end to the beginning

```python
alist = [1, 2, 3]
for item in reversed(alist):
    print(item)

# 3
# 2
# 1
```

---

## Iterators are Everywhere!

- `enumerate()`:  
Enumerates all elements of an iterable as such:  
(0, *first item*); (1, *second item*); (2, *third item*)

```python
alist = ["A", "B", "C"]
for item in enumerate(alist):
    print(item)

# (0, "A")
# (1, "B")
# (2, "C")
```

---

## Iterators are Everywhere!

- `zip()`:  
Allows you to "compress" two iterables into a tuple structure, until the end of the shortest iterable.

```python
list1 = ["Hello", "there", "General", "Kenobi"]
list2 = [1, 2]
zipped_tuple = zip(list1, list2)
for item in zipped_tuple:
    print(item)

# ('Hello', 1)
# ('there', 2)
```

---

## Standard Itertools Module

This [module](https://docs.python.org/3/library/itertools.html) brings a wide array of tools to work with iteration, we advise you to give it a read in your spare time.  
Some noteworthy methods:

- `itertools.takewhile(predicate, iterable)`:  
Takes elements from an iterable (or generator) while `predicate` is true.  
Argument `predicate` can be a simple comparison or a lambda function, for example.

- `itertools.chain(*iterables)`  
Takes various iterable objects and returns an iterator that ties all objects together (given two lists, it would return an iterator that once list1 is over, iteratres through list2).

---

## Under the Hood

This topic may be confusing for begginners of the language, but can provide an invaluable look into how Python magically handles iteration and for loops for you.

Every `Iterable` object can be called using the built-in function `iter()` to return an `iterator object`, which representes a **stream of data**.

```python
alist = [1, 2, 3, 4]
adict = {1: "a", 2: "b", 3: "c", 4: "d"}
astring = "Hello World!"

print(iter(alist))    # <list_iterator object at 0x02C02270>
print(iter(adict))    # <dict_keyiterator object at 0x02C2B8D0>
print(iter(astring))  # <str_iterator object at 0x02C02970>
```
***Note:*** 0x02C02270 represents the memory address where the list_iterator object was stored during our test run.

---

## Under the Hood

You can advance through the data stream of an iterator by calling the built-in function `next()`, which returns **successive items** from the **data stream**.

When all the data is read from the stream, the iterator is gone. If you were to call the function `next()` again, python would raise a `StopIteration` exception (exceptions are not covered in this workshop).

---

## Under the Hood

Here's how Python ***iterates through any iterable*** under the hood (as such it cannot use a for loop, because this is its own implementaion):

```python
def iterate(any_iterable, function_call):
    iterator = iter(any_iterable)
    continue_iterating = True
    while continue_iterating:
        try:
            item = next(iterator)
        except StopIteration:
            continue_iterating = False
        else:
            function_call(item)

alist = ["a", "b", "c", "d"]
iterate(alist, print)
```

---
template: slide_section
name: functions
# Functions

---

template: slide_normal
## Functions - Introduction 
Functions are essential in keeping code efficient and readable.
To define a function we declare:

+ The **Header** - Keyword ***def*** followed by the
name of the function and the ***parameters*** that it may
receive inside parenthesis.

+ The **Body** - The code of the function that produces intended result.
When the result is achieved the keyword **return**(*value*)
exits the function with a given value so that may be used on the function call.

+ Note: If the function reaches its end without reaching a return it will return ***None***.

---

## Functinos - Introduction

Big projects often have innumerous functions and it is often very difficult
to keep track of every single one of them.
In order to prevent confusion and make the code more readable functions
often have a ***docstring***: a string at the start of the ***function body***
, surrounded by """, that describes what is the ***input*** of the function, what it does
and its ***output***.

```python
def my_function(my_parameters):
    """docstring here"""
    # Function defined here
    return result
```

---

## Functions - Introduction

When a function is defined we can **call** it.
Its return value can then be used in expressions or attributions.

````python
var=my_function(my_parameters)
if(my_function(my_parameters))
````

### Example ###

(Adapted from Big C++)

Suppose that we are given a plethora of interest rates (in percentage) and we
want to compute the value of a savings account based on those interests.
The result must be the final balance of the account after 10 years, the initial balance
is $1000.

The balance can be calculated using this formula:

** b=1000 * (1+ (p/100)^10) **

---

## Functions - Example

So, firstly we need to define the ***header*** of the function.
The only parameter that we are going to use is the interest rate.

```python
def final_balance(interest_rate):
```

Secondly we need to compute the final balance into a variable.

```python
result = 1000 * (1 + p / 100) ** (10)
```

---

## Functions - Example

Lastly, having achieved our goal, we return the result and finish writing the function.

```python
def final_balance(interest_rate):
    result = 1000 * (1 + p / 100) ** (10)
    return result
```

We can then use the function to produce and compare different results using distinct
interest rates.

```python
print("${:.2f}".format(final_balance(5))) # 1628.89 $
print("${:.2f}".format(final_balance(10))) # 2593.74 $
print("${:.2f}".format(final_balance(25))) # 9313.23 $
```

---

## Functions - Example

But let's suppose that you wanted to change the initial deposit of the account
to 1500 and wanted to see the value of the deposit after 20 years.
The solution is to add the starting balance and the number of years as a new parameters
to the function definition.

```python
def final_balance(interest_rate, years=10, initial_value=1000):
    result = initial_value * (1 + p / 100) ** years
    return result
```

Notice how the parameters are assigned to a value in the function header.
This means that if the function is called without specifing the value of
years or initial_value they will have a value equal to their  ***default values***.

```python
print("{:.2f}".format(final_balance(5))) # 1628.89
print("{:.2f}".format(final_balance(5, 20, 1500))) # 3979.95
```

???
Falar como alguns metodos da string já têm default vals (como o [:])

---

## Functions - Important Tips

Some very important notes to keep in mind:

+ When you keep repeating the same code over and over again it is
    usually a sign that you could turn that code into a function.
  Doing this will drastically improve the readability of your code.

+ Try to name your functions in a way that is self describing. This also
    improves code readability.

 ```python
    interest_rate=5                         # What is more readable?
    print(final_balance(interest_rate))
    print(calc(interest_rate))
    print(1000*(1+interest_rate/100)**(10))
 ```

---

## Functions - Scope ##

Variables can be in one of three places in which Python will look for,
these places are called *scopes* (or *namespaces*):

1. **Local scope** - Variables that are defined inside of functions.
1. **Global scope** - Variables that are defined at the global level. (can be accessed everywhere)
1. **Built-in scope** - Variables that are predefined in Python.

Whenever Python looks for a variable, it will always look for it in the
previous order. To use a global variable inside a function call, use the global keyword.

**Note:** After you invoke a function and its execution ends, all the local variables
created by it are deleted by the garbage collector.

---

### Examples

```python
x=5
y=2
def func():
    x=7
    print("x:", x) # prints 7
    global y
    print("y:", y) # prints 2
    y = 4
    print("y:", y) # prints 4

func()
print("x:", x) # prints 5
print("y:", y) # prints 4
```

Although we may use global variables in this workshop, you should avoid using them
whenever possible, as they diminish readability and lead to increased memory
usage.

---

## Lambda Functions ##

Lambda functions are anonymous expressions used to create small functions on-the-fly.
Invoke them by using the keyword lambda, followed by its argument,
a colon and the function definition.

```python
print((lambda p: 1000 * (1 + p / 100) ** (10)) (5)) #  1628.89
```

---
template: slide_section
name: comprehensions_and_generators
# Comprehensions and Generators

---

template: slide_normal
## List Comprehensions

List comprehensions can be used to create a list from another iterator. You can apply **functions** or even **lambda functions** inside them to filter what you want.

For example, to create a new list with all positive numbers from a previous list:
```py
list1 = [12, 5, -4, 6, -18, 0, 4, 2]
list2 = [n for n in list1 if n > 0]
print(list2)

# [12, 5, 6, 4, 2]
```

---

## List Comprehensions

If you wanted to know the length of every word in a sentence:
```py
sentence = "List comprehensions rule"
n_words = [len(word) for word in sentence.split()]
print(n_words)

# [4, 14, 4]
```

Iterating through other structures is also viable, for example, extrating from a dictionary only the values whose key are an even number:
```py
adict = {1: "a", 2: "b", 3: "c", 4: "d"}
alist = [adict[key] for key in adict if key % 2 == 0]
print(alist)

# ['b', 'd']
```

---

## Generators

Generators are the next step once you've learned list comprehensions, as the following code has the exact same meaning:

```py
[item for item in iterable]
list(item for item in iterable) # Notice the cast to list
```

### Why Generators?

Just like *iterators*, generators are also ***lazy***, as they will *generate* the next element when asked to, instead of storing them all in memory.  
Their major advantage in comparison to iterators, is that the code required to create a generator is **significantly** more reduced and readable.

To create a generator, you can simply create a function, but instead of using a ***return*** statement, you call the ***yield*** statement.  

---

```py
def list_range(start, end, step=1):
    i, result = start, []
    while (i < end):
        result += i
        i += step
    return result

def generator_range(start, end, step=1):
    i = start
    while (i < end):
        yield i
        i += step

print(list_range(0, 10, 2))
print(generator_range(0, 10, 2))
print(list(generator_range(0, 10, 2)))

# [0, 2, 4, 6, 8]
# <generator object false_range at 0x012F0CF0>
# [0, 2, 4, 6, 8]
```

???

For an example of this behaviour, we implemented a minimalist version of the `range()` object.
Although the code is very similar, the performance impact is very different.  
As you can see, calling our ***yield*** function returned us a ***generator object***, but casting it to list returned the same as our function using ***return***
Now let's compare a call of these two approaches with a really large argument, as such, `range(0, 1000000)`.  
The function returning a list would have to allocate in memory a list with a whopping million elements... this is not prefereable.  
The generator function (*yield*) only returns one number at a time, therefore not filling system's memory with a million long list.

---

### Inline Generators

As you saw from the example comparing a list comprehensions to a generator, it can be written in a ***compact*** and ***lambda like*** format.

Just like in that example, where we used an iterable, **generators can use other generators** in their definition, which still maintains the generator lazy, keeping their advantages.

```py
square_generator = (n**2 for n in range(1, 10000000000))

from itertools import takewhile
list_squares = takewhile(lambda square : square <= 25, square_generator)

print(list(list_squares))

# [1, 4, 9, 16, 25]
```

***Note:*** Inline generators should always be inside parenthesis.

???

Actual infinite generator (in the representable integer range)

```py
def infinite_generator():
    a = 0
    while (True):
        yield a
        a += 1
```

---

### Conditions in Generators

Conditions can be incorporated in one of two ways:
- In the end, to indicate which elements to select:  
Selecting all positive elements
```py
[n for n in alist if n > 0]  
```
- In the beginning, to indicate how to return the selected element:  
Halving all even numbers and squaring all odd numbers
```py
[n / 2 if n % 2 == 0 else n**2 for n in alist]
```

---

### Conditions in Generators

For example, this next snippet combines both to halve even positive numbers and square positive odd numbers:

```py
alist = [-1, 2, -7, 3, 7, -9, -200, 20]
print(list( [n / 2 if n % 2 == 0 else n**2 for n in alist] ))

# [6, 9, 49, 10]
```

You can also chain multiple if else statements in the beginning, to create more complex generators:

```py
alist = [-4, -2, 0, 2, 4]
[1 if n < 0 else 2 if n < 4 else 3 for n in alist]

# [1, 1, 2, 2, 3]
```

---
template: slide_section
name: modules
# Modules

---

template: slide_normal
### Using Modules

To use modules in your scripts, simply use the `import` keyword.
You can use it to import an entire module, or some specific method, data type or constant from it. You can also rename their *namespace* during the import.   
Here's a couple of examples:

```py
import numpy
array1 = numpy.array([1, 2])

import numpy as np
array2 = np.array([3, 4])

from numpy import array
array3 = array([5, 6])

from numpy import array as np_array
array3 = np_array([7, 8])
```
---

### Standard Library Modules

For all standard library modules, check [the standard library](https://docs.python.org/3/library/).  
Here's some of the modules you'll see yourself using somewhat frequently:
- **[Math](https://docs.python.org/3/library/math.html)**:  
Math functions such as sin(), cos(), log(), and constants such as e and π.
- **[Random](https://docs.python.org/3/library/random.html)**:  
Pseudo-Random number generator, can generate numbers based on some statistical distributions.
- **[Time](https://docs.python.org/3/library/time.html)**:  
Provides a Time datatype to you, amazing module since times are painful to program.
- **[DateTime](https://docs.python.org/3/library/datetime.html)**:    
Provides a DateTime datatype to you, amazing module since dates and times are painful to program.
- **[Os](https://docs.python.org/3/library/os.html)**:  
Handles operating system related operation.

---

### External Modules

For all available modules, check [Python Package Index](https://pypi.org/). To install these, you will probably have to use a `pip install` command on the terminal, or some similar method (Anaconda brings lots of external modules already).  
Here's a highlight of some great modules:
- **[NumPy](https://numpy.org/) & [ScyPy](https://www.scipy.org/)**:  
Uses code written in C to boost computing speed and introduce computation with matrices and other mathematical data structures.
- **[MatPlotLib](https://matplotlib.org/)**:  
Plot graphs, bar graphs, histograms and more.
- **[Seaborn](https://seaborn.pydata.org/index.html)**:  
Statistical data visualization.
- **[Pandas](https://pandas.pydata.org/)**:  
Process large data from files and apply statistics related methods.
- **[SciKit-Learn](https://scikit-learn.org/stable/index.html)**:  
Regressions, machine learning and more.
- **[TensorFlow](https://www.tensorflow.org/)**:  
Machine learning, neural networks and deep learning.

---
template: slide_title
# End

### We hope you keep programming in Python!
