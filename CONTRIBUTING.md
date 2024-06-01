# Contributing

Contributions are **welcome** and will be fully **credited**.

We accept contributions via Pull Requests on
[GitHub](https://github.com/codelibrary/world/pulls).
**Do not open up a GitHub issue if the bug is a security vulnerability**, and
instead send email to niks986@gmail.com.

## Pull Requests

- **[PSR-12 Extended Coding Style][PSR-12 Extended Coding Style Guide]** -
  The easiest way to apply the conventions is to install
  [PHP Code Sniffer][Package Information: PHP_CodeSniffer].

- **Add tests!** - Your patch won't be accepted if it doesn't have tests.

- **Document any change in behaviour** - Make sure the `README.md` and any other
  relevant documentation are kept up-to-date.

- **Consider our release cycle** - We try to follow
  [Semantic Versioning v2.0.0][SemVer v2.0.0].
  Randomly breaking public APIs is not an option.

- **Create feature branches** - Don't ask us to pull from your master branch.

- **One pull request per a feature** - If you want to do more than one thing,
  send multiple pull requests.

- **Send coherent history** - Make sure each individual commit in your
  pull request is meaningful. If you had to make multiple intermediate
  commits while developing, please
  [squash them][Git Tools-Rewriting History: Changing Multiple Commit Messages]
  before submitting.

## Running Tests

``` bash
$ composer test
```

**Happy coding**!

[PSR-12 Extended Coding Style Guide]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-12-extended-coding-style-guide.md
[Package Information: PHP_CodeSniffer]: https://pear.php.net/package/PHP_CodeSniffer
[SemVer v2.0.0]: https://semver.org/spec/v2.0.0.html
[Git Tools-Rewriting History: Changing Multiple Commit Messages]: https://www.git-scm.com/book/en/v2/Git-Tools-Rewriting-History#_changing_multiple
