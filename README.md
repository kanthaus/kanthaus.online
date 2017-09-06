# Kanthaus

Informative website for the Kanthaus Project, all documents and meeting notes are also stored here in the contents folder.

## Technology
This website was created using [Hugo](https://gohugo.io/).

## How to add new documents
To add new documents to this repo (repository) you will need a gitlab account with the correct permissions to add files to this repository

There are two easy options to add documents.
For either option you will need to have the correct access to this repo.

1>
- Clone this repo:
  ```
  git clone https://gitlab.com/kanthaus/kanthaus.gitlab.io.git```
- edit the markdown (.md) files in the content folder
- git add . (add all changes)
- git commit -m "your changes eg. added new meeting notes"
- git push (you will be asked for your login details)

2>
- login to an account which has access to this repository
- view the source files
- enter the contents folder
- use gitlab's online code editor to change the content

## How to add multilingual pages/posts
To make an existing translations appear on the website, you need to create an `.md` file that uses the right language code extension before `.md`.
For example:
`contact.md` needs to be called `contact.de.md`, if it contains a German translation and `contact.en.md`, if it contains an English translation.

