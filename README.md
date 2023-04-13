# Monday API
Monday.com API

## Installation & loading
Monday API is available on [Packagist](https://packagist.org/packages/tblack-it/monday-api) (using semantic versioning), and installation via [Composer](https://getcomposer.org) is the recommended way to install Monday API. Just add this line to your `composer.json` file:

```json
"galata/laravel-monday-api": "~0.1"
```

or run

```sh
composer require galata/laravel-monday-api
```

This package uses autodiscovery, so you don't have to manually add anything to your config/app.php.

### In case you do not use autodiscovery:

Add the ServiceProvider and the Facade to your `config/app.php`:

```php
'providers' => [
  ...
  Galata\LaravelMondayAPI\MondayServiceProvider::class,
],
'aliases' => [
  ...
  'Monday' => Galata\LaravelMondayAPI\MondayFacade::class,
]
```

*OPTIONAL* Then run the following command to publish the config to your config/ directory.
It should be enough to add MONDAY_TOKEN=MYTOKEN to your .env file.

```bash
$ php artisan vendor:publish --tag=config
```

```php
return [
    'monday_token' => 'MYTOKEN', // the token for your tenant on monday.com
];
```

## Usage

Interact with boards
```php

# Get all boards
$all_boards = Monday::getBoards();

# Get Board id : 10012
$board_id = 10012;
$board = Monday::on($board_id)->getBoards();

# Get Board Columns
$board_id = 10012;
$boardColumns = Monday::on($board_id)->getColumns();

# Create Board, if success return board_id
$newboard = Monday::create( 'New Board Name', Galata\LaravelMondayAPI\MondayAPI\ObjectTypes\BoardKind::PUB );
$board_id = $newboard['create_board']['id'];

```

Interact with Itens
```php
# Insert new Item on Board
$board_id = 10012;
$id_group = 'topics';
$column_values = [ 'text1' => 'Value...','text2' => 'Other value...' ];

$addResult = Monday::on($board_id)
              ->group($id_group)
              ->addItem( 'My Item Title', $column_values );

# If you want to use the `create_labels_if_missing` arguments; just add `true` as the third arguments (default: `false`)
$addResult = Monday::on($board_id)
              ->group($id_group)
              ->addItem( 'My Item Title', $column_values, true);

# if succes return
$item_id = $addResult['create_item']['id'];

# For update Item
$item_id = 34112;
$column_values = [ 'text1' => 'New Value','text2' => 'New other value...' ];

$updateResult = Monday::on($board_id)
              ->group($id_group)
              ->changeMultipleColumnValues($item_id, $column_values );

# Archive item
$result = Monday::on($board_id)
              ->group($id_group)
              ->archiveItem($item_id);

// Delete item
$result = Monday::on($board_id)
              ->group($id_group)
              ->deleteItem($item_id);

```

If you need specific action, you can run a custom Query or Mutation
```php

// Run a custom query
$query = '
boards (ids: 12121212) {
  groups (ids: group_id) {
    items {
      id
      name
      column_values {
        id
        text
        title
      }
    }
  }
}';

# For Query
$items = Monday::customQuery( $query );

# For Mutation
$items = Monday::customMutation( $query );
```
