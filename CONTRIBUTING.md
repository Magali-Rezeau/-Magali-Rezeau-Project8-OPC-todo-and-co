Project8-OPC-todo-and-co

# Contributing guidelines

This is a guide to contributing to Todo and Co project.

1. Set up a working copy on your computer.
------------------------------------------
Firstly you need a local fork of the the project, so go ahead and press the “fork” button . This will create a copy of the repository in your own GitHub account and you’ll see a note that it’s been forked underneath the project name.
Now you need a copy locally, so find the “SSH Clone URL” in the right column and use it to clone locally using a terminal:
```
    git clone https://github.com/Magali-Rezeau/Project8-OPC-todo-and-co.git
```


2. Get it working on your machine.
----------------------------------
Now that you have the source code, get it working on your computer by referring to README INSTRUCTIONS.


3. Do some work.
----------------
#### Create a branch
Navigate to the repository directory on your computer.Create the new branch using a logical name corresponding to the changes or new features :
```
    git checkout -b new-feature
```
For this project, we are using a free code reviewer that automates code reviews and monitors code quality over time : Codacy.

Recommendations to follow :
* Run PHPUnit regularly to verify the code.Implement your own tests, but make sure you don't decrease code coverage (100%).
* Make sure you don't modify existing tests.

#### Run the tests
To implement new tests, refer to the official Symfony documentation.
Run the tests with generation of a code coverage report to ensure that all the new code is running :
```
    bin / phpunit --coverage-html tests/test-coverage
```

#### Validate the modifications
Commit your changes.
Clearly detail the changes made.
```
    git add .
    git commit -m 'commit message'
```


4. Create the pull-request.
---------------------------
Go to the Pull Requests section of our project and create your pull request.
Go to your forke repository, you will see that your new branch is listed at the top with a handy "Compare & pull request" button. Click on this button.
Be sure to provide a short title and explain why you created it, in the description box.
You must now submit the extract request to the original repository. To do this, press the "Create pull request" button and you are done.


5. Review by the maintainers.
-----------------------------
For your work to be integrated into the project, the maintainers will review your work and either request changes or merge it.