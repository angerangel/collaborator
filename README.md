collaborator
============

Software for share files and versioning, esay, simple, no DB requested, just PHP. It work with text and binary files like DOC, JPG, MP3, anything. If you try to update a file, it advice you that if your current version is not the last one; this way conflict between versions on binary files are resolved _(I hope...)_. 
It's like a control version system, but very easy.

You can revert to any old file version, all versions are saved as separete files, so you don't risk to lose your work if the database becomes corrupted.

It's intended for very small groups, since it uses SQLite3 embedded database.


# How it works?

Just put all files in your website, log in using:

 * **user:** admin
 * **password:** admin
  
Now you can upload and update files, add and delete users.

# What are users?

There are 2 type of users:

 * administrators
 * normal users

Normal user can upload new files, update files permitted to him, download files permitted to him.

Administrators can do all normal user tasks plus: create and delete users, change users passwords, change permissions, revert to old file versions.

# What are permissions?

If a user has a permission on a file, he can download and update a file.

# Contacts

You can email me to angerangel@gmail.com 