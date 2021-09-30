# How to contribute

I'm really glad you're reading this, because we need volunteer developers to help this project come to fruition.

You can get updates about the current state of this project from our [Twitter](https://www.twitter.com/seajelldev) profile.

Here are some important resources:

  * [Documentation](https://docs.seajell.xyz) guides user on how to use the project.

## Testing

Since we don't have any tests for tools such as PHP Unit yet, all tests must be done manually.

## Submitting changes

Please send a [GitHub Pull Request](https://github.com/seajell/seajell/pull/new/main) with a clear list of what you've done (read more about [pull requests](http://help.github.com/pull-requests/)). Please follow our coding conventions (below) and make sure all of your commits are atomic (one feature per commit).

Always write a clear log message for your commits. One-line messages are fine for small changes, but bigger changes should look like this:

    $ git commit -m "A brief summary of the commit
    > 
    > A paragraph describing what changed and its impact."

## Coding conventions

Start reading our code and you'll get the hang of it. We optimize for readability:

  * We indent using 4 spaces (based on Visual Studio Code basic setting).
  * We use Blade HTML for all views.
  * Only use logics in views when necessary.
  * Descriptive name for classes, variables etc is preferred.
  * Please use `camelCase` for variable, method, function and class names and please use `kebab-case` for HTML and CSS related names. 
  * As long as the code is readable and understandable, we can accept it. Comments can be included to futher explain your code.
  * Always store public facing images in the `storage/app/public/img` folder. The public images could be access through `/storage/img` path.
  * This is open source software. Consider the people who will read your code, and make it look nice for them. It's sort of like driving a car: Perhaps you love doing donuts when you're alone, but with passengers the goal is to make the ride as smooth as possible.

Thanks,
Muhammad Hanis Irfan bin Mohd Zaid, Original Author of SeaJell.

_These guidelines is adapted from [Open Government contribution guidelines](https://github.com/opengovernment/opengovernment/blob/master/CONTRIBUTING.md)._
