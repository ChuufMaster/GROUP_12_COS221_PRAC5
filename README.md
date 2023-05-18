# General Info For The Prac

## Table of Contents
- [General Info For The Prac](#general-info-for-the-prac)
  - [Table of Contents](#table-of-contents)
  - [Folder specific Readme](#folder-specific-readme)
  - [Coding practices](#coding-practices)
  - [installation](#installation)
  - [Recommended Extensions](#recommended-extensions)
    - [GitHub](#github)
    - [Markdown](#markdown)
    - [General](#general)
    - [CSS](#css)
    - [Diagrams](#diagrams)
    - [HTML](#html)
    - [JavaScript](#javascript)
    - [PHP](#php)
  - [Usage](#usage)
    - [Git Command Line](#git-command-line)
    - [GitHub Desktop](#github-desktop)

## Folder specific Readme

- [Applications](applications/applications.md)
- [Database](Database/database.md)
- [Documents](Documents/documents.md)
- [EER](EER/EER.md)
- [Front_End](Front_END/frontend.md)
  - [CSS](Front_END/CSS/CSS.md)
    - [CSS_General](Front_END/CSS/General/general_css.md)
  - [HTML](Front_END/HTML/HTML.md)
  - [JavaScript](Front_END/JS/JS.md)
- [Research](Research/research.md)
- [Resources](Resources/resources.md)



## Coding practices

1. **Videos**

   - Watch and implement all the practices specified in the videos on this guys channel
   - https://www.youtube.com/@CodeAesthetic


2. Please make sure to keep the naming of variables as descriptive as possible
3. Avoid more than three levels of indentation/nesting at most
   1. Use extraction to lower the level of nesting or indentation
   2. Use gatekeeping so instead of have a bunch of if-else statements test for all the worst case scenarios before getting to the actual code that you want to execute
4. If a function or piece of code can be put into its own file then do it don't have one big file
5. You naming of functions and variables should be able to be read like a comment

## installation

- There is nothing to see here yet.

## Recommended Extensions

### GitHub

1. **GitLens**

### Markdown

1. **Markdown All in One**

### General

1. **Code Spell Checker**
2. **Path Intellisense**
3. **Prettier - Code formatter**

### CSS

1. **CSS Formater**
2. **CSS Peek**

### Diagrams

1. **Draw.io Integration**

### HTML

1. **Format HTML in PHP**
2. **HTML CSS Support**

### JavaScript

1. **IntelliCode**
2. **IntelliCode API Usage Examples**
3. **JavaScript (ES6) code snippets**
4. **jQuery Code Snippets**

### PHP

1. **PHP**
2. **PHP Extension Pack**
3. **PHP Intelephense**
4. **PHP Profiler**

## Usage

### Git Command Line

1. **Creating a Repository**

   - Go to [GitHub](https://github.com/) and sign in or create a new account.
   - Click on the **+"** button on the top right corner and select **"New repository"**.
   - Provide a **Repository name** and choose the repository's **visibility** (public or private).
   - Optionally, add a **description**, choose to initialize with a **README**, and select a **license**.
   - Click on **"Create repository"**.

2. **Cloning a Repository**

   - On the repository page, click on the **"Code"** button and copy the repository's URL.
   - Open your terminal or command prompt and navigate to the directory where you want to clone the repository.
   - Run the following command, replacing `<repository-url>` with the URL you copied:

     ```
     git clone <repository-url>
     ```

3. **Making Changes**

   - Navigate to the cloned repository using the terminal or command prompt.
   - Create or modify files in the repository using your preferred text editor.
   - Use the following commands to stage and commit your changes:

     ```
     git add .
     git commit -m "Descriptive commit message"
     ```

4. **Pushing Changes**

   - If you cloned an existing repository, use the following command to fetch and merge any new changes:

     ```
     git pull origin main
     ```

   - Push your committed changes to the remote repository using the following command:

     ```
     git push origin main
     ```

5. **Branching and Pull Requests**

   - To create a new branch, use the following command:

     ```
     git branch <branch-name>
     ```

   - Switch to the new branch using:

     ```
     git checkout <branch-name>
     ```

   - Make changes, commit, and push the branch to the remote repository:

     ```
     git push origin <branch-name>
     ```

   - On the GitHub repository page, click on the **"Compare & pull request"** button next to the branch name.
   - Review the changes and click on **"Create pull request"** to submit the changes for review.

6. **Collaboration and Forking**

   - To collaborate with others, you can fork a repository to create your copy.
   - On the repository page, click on the **"Fork"** button at the top right corner.
   - Clone the forked repository to your local machine and make changes.
   - Push the changes to your forked repository and create a pull request to contribute your changes to the original repository.

This is a basic overview of using GitHub for version control and collaboration. It covers the essential steps to create repositories, clone them, make changes, push changes, create branches, and collaborate with others. Remember to refer to the official [GitHub documentation](https://docs.github.com/) for more detailed information and advanced features.

### GitHub Desktop

1. **Creating a Repository**

   - Go to [GitHub](https://github.com/) and sign in or create a new account.
   - Click on the **+"** button on the top right corner and select **"New repository"**.
   - Provide a **Repository name** and choose the repository's **visibility** (public or private).
   - Optionally, add a **description**, choose to initialize with a **README**, and select a **license**.
   - Click on **"Create repository"**.

2. **Cloning a Repository**

   - On the repository page, click on the **"Code"** button and copy the repository's URL.
   - Open GitHub Desktop.
   - Click on **"File"** and select **"Clone Repository"**.
   - In the **"URL"** tab, paste the repository's URL and choose a local path for the cloned repository.
   - Click on **"Clone"**.

3. **Making Changes**

   - Open the cloned repository in GitHub Desktop.
   - Create or modify files in the repository using your preferred text editor or GitHub Desktop's built-in editor.
   - GitHub Desktop will automatically detect any changes made to the files.

4. **Committing Changes**

   - In the left sidebar of GitHub Desktop, you'll see a list of changed files.
   - Check the box next to the files you want to include in the commit.
   - Enter a **summary** and **description** of the changes made.
   - Click on **"Commit to main"** (or the appropriate branch name).

5. **Pushing Changes**

   - After committing your changes, click on **"Push origin"** at the top of GitHub Desktop.
   - This will push your committed changes to the remote repository.

6. **Branching and Pull Requests**

   - To create a new branch, click on the **"Current branch"** dropdown on the top left of GitHub Desktop.
   - Enter a name for the new branch and press **Enter**.
   - Make changes to the files in the new branch and commit them as before.
   - To create a pull request, go to the repository's page on GitHub.
   - GitHub Desktop will provide a prompt to create a pull request for the current branch.
   - Fill in the necessary details and click on **"Create pull request"**.

7. **Collaboration and Forking**

   - To collaborate with others, you can fork a repository to create your copy.
   - On the repository page, click on the **"Fork"** button at the top right corner.
   - Clone the forked repository to your local machine using GitHub Desktop.
   - Make changes, commit them, and push to your forked repository.
   - On the GitHub website, create a pull request from your forked repository to contribute your changes to the original repository.

This is a basic overview of using GitHub and GitHub Desktop for version control and collaboration. It covers the essential steps to create repositories, clone them, make changes, commit changes, create branches, and collaborate with others. Remember to refer to the official [GitHub documentation](https://docs.github.com/) and [GitHub Desktop documentation](https://docs.github.com/en/desktop) for more detailed information and advanced features.

