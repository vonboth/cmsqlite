<?php

namespace App\Commands;

use Admin\System\Updates;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Files\FileCollection;
use Config\Database;

/**
 * Class CmsqliteUpdateCommand
 *
 * @package App\Commands
 */
class UpdateCommand extends BaseCommand
{
    /** @inheritdoc */
    public $group = 'CMSQLite';

    /** @inheritdoc */
    public $name = 'cmsqlite:update';

    /** @inheritdoc */
    public $description = 'Update CMSQLite';

    public $usage = 'cmsqlite:update';

    /**
     * @inheritDoc
     */
    public function run(array $params)
    {
        $files = new FileCollection([ADMINPATH . 'Updates']);

        try {
            foreach ($files as $file) {
                $db = Database::connect();

                $fileName = $file->getFilename();
                /** @var Updates $update */
                $update = require ADMINPATH . 'Updates/' . $fileName;
                $update->setDb($db);
                $version = $update->getVersion();

                if (empty($version)) {
                    CLI::error('Version not found in ' . $fileName);
                    continue;
                }

                $row = $db->table('updates')->where('version', $version)->get()->getRow();

                if (!$row) {
                    CLI::write('Updating CMSQLite to version ' . $version, 'green');

                    // migrate the database
                    CLI::write('migrating tables', 'green');
                    $this->call('migrate');

                    // load the file and execute the update
                    CLI::write('Running updates', 'green');
                    $update->up();

                    $db->table('updates')->insert([
                        'version' => $version,
                        'success' => 1,
                        'created' => date('Y-m-d H:i:s')
                    ]);

                    CLI::write("Version $version applied successfully", 'green');
                } else {
                    CLI::write("Version $version already installed", 'yellow');
                }
            }
        } catch (\Exception $exception) {
            log_message('error', 'update error: ' . $exception->getMessage());
            CLI::error('Something went wrong while updating CSMQLite: ' . $exception->getMessage());
        }
    }
}
