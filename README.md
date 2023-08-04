# TRAX Framework 2.0.4


## About TRAX Framework

TRAX Framework is a Laravel package developed for the [TRAX LRS project](http://traxlrs.com).

It provides the following features:

- Authentication and authorization system
- Data repository with CRUD operations
- xAPI store


## Sofware License & Copyright

TRAX Framework is dual-licensed under:

- [GNU-GPL3 license](https://www.gnu.org/licenses/gpl-3.0.fr.html)
- [TRAX LRS 2.0 Extended Edition license](https://github.com/trax-project/trax2-extended-lrs/blob/master/services/trax/docs/2.0/license.md)

Copyright 2022 Sébastien Fraysse, http://fraysse.eu, sebastien@fraysse.eu.


## Customized or Enabled Features

### DELETE on statements is now allowed
Enabled statement delete operation based using the below example. `filters` is required param in the below format.

```
[
    filters: {"data->actor->mbox": "mailto:some_email@example.com"}
]
```

The full request would look something like 

```
DELETE /trax/api/c0a47292-fb7b-4e19-9473-ad186c86ab8c/xapi/ext/statements?filters=%7B%22data-%3Eactor-%3Embox%22%3A%20%22mailto%3Asome_email%example.com%22%7D
```
