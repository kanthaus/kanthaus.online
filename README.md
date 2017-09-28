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
  git clone https://gitlab.com/kanthaus/kanthaus.gitlab.io.git
  ```
- edit the markdown (.md) files in the content folder
- git add . (add all changes)
- git commit -m "your changes eg. added new meeting notes"
- git push (you will be asked for your login details)

2>
- login to an account which has access to this repository
- view the source files
- enter the contents folder
- use gitlab's online code editor to change the content

## Multilingual

We use crowdin for the translations, original language is English, and we translate to German.

This means you should write documents first in English, and without a language prefix, e.g.:
`about.md` (not `about.en.md`).

Then go to [crowdin.com/project/kanthausonline/de](https://crowdin.com/project/kanthausonline/de)
to translate to German.

It will then create a [merge request](https://gitlab.com/kanthaus/kanthaus.gitlab.io/merge_requests)
for you with the changes.

## Webserver config

We use this config:

```nginx
location = /sitemap.xml {
}

location ~ ^/(en|de|css|pics)/ {
        try_files $uri $uri/ =404;
}

location / {
  set_by_lua_block $default_lang {
    for lang in (ngx.var.http_accept_language .. ","):gmatch("([^,]*),") do
      if string.sub(lang, 0, 2) == "en" then
        return "en"
      end
      if string.sub(lang, 0, 2) == "de" then
        return "de"
      end
    end
    return "de"
  }
  return 302 /$default_lang$request_uri;
}
```

It allows you to share links without a language code in them, and the user
will be redirected to the correct language depending on their browser settings.

E.g.

* link to share https://kanthaus.online/about/
* German redirects to https://kanthaus.online/de/about/
* English redirects to https://kanthaus.online/en/about/