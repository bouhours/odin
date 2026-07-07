# Contributing Guidelines

Thank you for your interest in contributing to this project. Contributions are welcome, whether they are bug reports, documentation improvements, feature proposals, tests, refactoring, or code changes.

Please read these guidelines before opening an issue or pull request. They help maintainers review contributions efficiently and keep the project healthy.

## Table of Contents

- [Code of Conduct](#code-of-conduct)
- [Before You Start](#before-you-start)
- [Reporting Bugs](#reporting-bugs)
- [Requesting Features](#requesting-features)
- [Submitting Pull Requests](#submitting-pull-requests)
- [Branch Naming](#branch-naming)
- [Commit Messages](#commit-messages)
- [Development Workflow](#development-workflow)
- [Tests and Quality Checks](#tests-and-quality-checks)
- [Documentation](#documentation)
- [Security Issues](#security-issues)
- [Maintainer Review Process](#maintainer-review-process)

## Code of Conduct

By participating in this project, you agree to follow our [Code of Conduct](CODE_OF_CONDUCT.md). Please be respectful, constructive, and collaborative.

## Before You Start

Before creating an issue or pull request:

1. Search existing issues and pull requests to avoid duplicates.
2. Make sure your change is aligned with the scope of the project.
3. For large changes, open an issue first to discuss the proposal with maintainers.
4. Do not open public issues for security vulnerabilities. See [Security Issues](#security-issues).

## Reporting Bugs

When reporting a bug, please include:

- A clear and descriptive title.
- The version, commit, or release you are using.
- Your operating system and relevant environment details.
- Steps to reproduce the issue.
- The expected behavior.
- The actual behavior.
- Logs, stack traces, screenshots, or minimal reproduction examples when possible.

A good bug report helps maintainers reproduce and fix the issue faster.

## Requesting Features

Feature requests are welcome. Please explain:

- The problem or use case you are trying to solve.
- Why this feature belongs in the project.
- Any alternatives or workarounds you considered.
- Whether you are willing to help implement or test it.

Please avoid opening pull requests for major features before discussing them in an issue.

## Submitting Pull Requests

Pull requests should be focused, reviewable, and linked to an issue when possible.

Before opening a pull request:

1. Fork the repository.
2. Create a dedicated branch from `main`.
3. Make your changes in small, logical commits.
4. Add or update tests when relevant.
5. Update documentation when behavior changes.
6. Run the project checks locally if available.
7. Open a pull request against `main`.

A pull request should include:

- A clear description of the change.
- A link to the related issue, if any.
- Screenshots or examples for user-facing changes.
- Notes about breaking changes, migrations, or compatibility concerns.

## Branch Naming

Use short, descriptive branch names:

```text
feature/add-export
fix/login-error
docs/update-installation
refactor/config-loader
test/add-api-coverage
chore/update-dependencies
```

Avoid vague names such as `changes`, `fix`, `work`, or `update`.

## Commit Messages

Use clear commit messages. Prefer the following format:

```text
type: short description
```

Recommended types:

```text
feat:     new feature
fix:      bug fix
docs:     documentation only
style:    formatting only
refactor: code change that neither fixes a bug nor adds a feature
test:     tests added or updated
chore:    maintenance work
ci:       continuous integration changes
build:    build system or dependency changes
perf:     performance improvement
revert:   revert a previous change
```

Examples:

```text
fix: handle missing configuration file
feat: add JSON export option
docs: clarify installation steps
test: add coverage for parser edge cases
```

## Development Workflow

A typical workflow is:

```bash
git clone https://github.com/YOUR_USERNAME/odin.git
cd odin
git checkout -b fix/short-description
# make changes
# run tests/checks
git commit -m "fix: short description"
git push origin fix/short-description
```

Then open a pull request on GitHub.

## Tests and Quality Checks

If the project provides automated checks, please run them before submitting a pull request.

Examples may include:

```bash
# Examples only; adapt to this project
npm test
npm run lint
pytest
cargo test
go test ./...
```

Pull requests may be blocked until required checks pass.

## Documentation

Please update documentation when your change affects:

- Installation steps.
- Configuration.
- Public APIs.
- User-visible behavior.
- Command-line options.
- Security or deployment guidance.

## Security Issues

Do not report security vulnerabilities in public issues. Please follow the instructions in [SECURITY.md](SECURITY.md).

## Maintainer Review Process

Maintainers may ask for changes before merging. Please keep discussions focused and respectful.

A pull request may be closed if it:

- Is out of scope for the project.
- Duplicates existing work.
- Cannot be reviewed due to missing information.
- Introduces unacceptable maintenance, security, or compatibility risks.
- Remains inactive after requested changes for an extended period.

Thank you for helping improve this project.
