# SMPL Suite

This is the SMPL suite of libraries as a monorepo.

## What is SMPL?

SMPL stands for "Simple, Modern PHP Libraries",
and is a framework consisting of a suite of libraries.
Each library can be used independently, save for a few cross-dependencies.

It's all still very much in development.

## Libraries

SMPL libraries fall into one of four categories.

| Category      | Description                                                                                                                                                                                                                              |
|---------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **Utility**   | Utility libraries are small sets of supporting functionality, designed to be used in larger libraries or software.                                                                                                                       |
| **Component** | Component libraries provide features by utilising utility libraries and sometimes other components.                                                                                                                                      |
| **Meta**      | Meta libraries are simple contract-based libraries that provide the bar minimum required to implement a custom solution, or integrate with a component. Not all components have a meta library, but all meta libraries have a component. |
| **Tool**      | Tool libraries are larger and typically utilise multiple utilities and components to provide tooling, or features of a specific purpose.                                                                                                 |

The following components are included in this repo.

### Collections

The Collections library provides a number of collections,
which are object-based alternatives to arrays, with implementations of a number of common data-structures.

This is a **Utility** library.

[View Component](./components/collections)

### Events

The Events library provides an event bus implementation.

This is a **Component** library.

[View Component](./components/events)

### Logic

The Logic library provides a number of contracts and implementations of common logical processes,
the sort typically found in functional programming.

This is a **Utility** library.

[View Component](./components/logic)

### Reflection

The Reflection library provides a number of tools to make working with PHP reflection much simpler.

This is a **Component** library.

[View Component](./components/reflection)
