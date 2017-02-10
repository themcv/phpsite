<?php
/**
 * Simple CMS example class.
 *
 * This is an example CMS class namely for learning.
 *
 * PHP version 5
 *
 * @category SimpleCMS
 * @package  PHPSite
 * @author   THEMCV <nah@nah.com>
 * @license  linktolicense ????SimpleNameOfLicenses
 * @link     https://github.com/themcv/phpsite
 */
/**
 * Simple CMS example class.
 *
 * This is an example CMS class namely for learning.
 *
 * @category SimpleCMS
 * @package  PHPSite
 * @author   THEMCV <nah@nah.com>
 * @license  linktolicense ????SimpleNameOfLicenses
 * @link     https://github.com/themcv/phpsite
 */
class simpleCMS {
    /**
     * Recommend to use typical OOP based property assignments.
     *
     * These include public, private, and protected.
     * var will just make the variables public. Scopes you should
     * learn from the docs.
     *
     * const is also valid for "constant" properties.
     */
    /**
     * DB name to work from.
     *
     * @var string
     */
    const DB_NAME = 'testDB';
    /**
     * DB Connector (e.g. mysql, oracle, etc...)
     *
     * @var string
     */
    const DB_TYPE = 'mysql';
    /**
     * DB host to connect to.
     *
     * @var string
     */
    const DB_HOST = 'localhost';
    /**
     * DB user to connect with.
     *
     * @var string
     */
    const DB_USER = 'root';
    /**
     * DB password to use.
     *
     * @var string
     */
    const DB_PASS = '';
    /**
     * The table to work within.
     *
     * @var string
     */
    public static $table = 'testDB';
    /**
     * Stores the current db connection.
     *
     * @var resource
     */
    private static $_link = null;
    /**
     * Any options you may want set.
     *
     * @var array
     */
    private static $_options = array(
        PDO::ATTR_PERSISTENT => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => true
    );
    /**
     * Stores the current query result.
     *
     * @var object
     */
    private static $_queryResult;
    /**
     * Initializes our class.
     *
     * @param array $options any custom options
     *
     * @throws PDOException
     * @return void
     */
    public function __construct($options = array())
    {
        if (count($options) > 0) {
            self::$_options += $options;
        }
        if (self::$_link) {
            self::_connectDb();
        }
        if (!self::$_link) {
            die(_('Could not connect to database'));
        }
    }
    /**
     * Connects to the database.
     *
     * @return void
     */
    private static function _connectDb()
    {
        $type = self::DB_TYPE;
        $name = self::DB_NAME;
        $host = self::DB_HOST;
        $user = self::DB_USER;
        $pass = self::DB_PASS;
        $dsn = sprintf(
            '%s:host=%s;dbname=%s;charset=utf8',
            $type,
            $host,
            $name
        );
        try {
            /**
             * If DB is already connected, we shouldn't need to reconnect.
             */
            if (self::$_link) {
                return;
            }
            /**
             * Establish the connection.
             */
            self::$_link = new PDO(
                $dsn,
                $user,
                $pass,
                self::$options
            );
        } catch (PDOException $e) {
            $msg = sprintf(
                '%s %s: %s: %s',
                _('Failed to'),
                __FUNCTION__,
                _('Error'),
                $e->getMessage()
            );
            die($msg);
        }
    }
    /**
     * Prepares the query.
     *
     * @return void
     */
    private static function _prepare($query)
    {
        self::$_queryResult = self::$_link->prepare($query);
    }
    /**
     * Bind the values as needed.
     *
     * @param string $param The parameter to bind.
     * @param mixed  $value The vlue to bind.
     * @param int    $type  The way to bind if needed.
     *
     * @return void
     */
    private static function _bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (gettype($value)) {
            case 'integer':
                $type = PDO::PARAM_INT;
                break;
            case 'boolean':
                $type = PDO::PARAM_BOOL;
                break;
            case 'NULL':
                $type = PDO::PARAM_NULL;
            default:
                $type = PDO::PARAM_STR;
            }
        }
        self::$_queryResult->bindParam($param, $value, $type);
    }
    /**
     * Executes the query.
     *
     * @param array $paramvals the parameters if any
     *
     * @return bool
     */
    private static function _execute($paramvals = array())
    {
        if (count($paramvals) > 0) {
            foreach ((array)$paramvals as $param => &$value) {
                if (is_array($value)) {
                    self::_bind($param, $value[0], $value[1]);
                    continue;
                }
                self::_bind($param, $value);
                unset($value);
            }
        }
        return self::$_queryResult->execute();
    }
    /**
     * Initial display to user.
     *
     * @return void
     */
    public function displayPublic() {
        $query = sprintf(
            'SELECT * FROM `%s` ORDER BY `created` DESC LIMIT 3',
            self::$table
        );
        self::_prepare($query);
        self::_execute();
        if (is_bool(self::$_queryResult)) {
            $result = self::$_queryResult;
            $numrows = 0;
        } else {
            $numrows = (int)self::$_queryResult->columnCount();
        }
        ob_start();
        if ($numrows > 0) {
            while ($row = self::$_queryResult->fetchAll()) {
                foreach ((array)$row as $key => &$val) {
                    self::_sanitizeItems($row[$key]);
                    unset($val);
                }
                /**
                 * Extracts data in an unpacking form.
                 * For example:
                 * row['title'] will have variable set as:
                 * $title = $row['title']
                 */
                extract($row);
                echo self::tag(
                    'h2',
                    $title
                );
                echo self::tag(
                    'p',
                    $bodytext
                );
            }
        } else {
            echo self::tag(
                'h2',
                _('Page under construction')
            );
            echo self::tag(
                'p',
                sprintf(
                    '%s. %s!',
                    _('No entries have been made on this page'),
                    _('Please check back soon or click the link below to add an entry')
                )
            );
            echo self::tag(
                'p',
                self::tag(
                    'a',
                    _('Add a new entry'),
                    array(
                        'href' => $_SERVER['PHP_SELF']
                    )
                ),
                array(
                    'class' => 'admin_link'
                )
            );
        }
        return ob_get_clean();
    }
    /**
     * Displays the admin form.
     *
     * @return string
     */
    public function displayAdmin() {
        return self::tag(
            'form',
            sprintf(
                '%s%s%s%s',
                self::tag(
                    'label',
                    sprintf(
                        '%s:',
                        _('Title')
                    ),
                    array(
                        'for' => 'title'
                    )
                ),
                self::tag(
                    'input',
                    '',
                    array(
                        'name' => 'title',
                        'id' => 'title',
                        'type' => 'text',
                        'maxlength' => '150',
                        'value' => $_POST['title']
                    )
                ),
                self::tag(
                    'textarea',
                    $_POST['bodytext'],
                    array(
                        'name' => 'bodytext',
                        'id' => 'bodytext',
                    )
                ),
                self::tag(
                    'input',
                    '',
                    array(
                        'type' => 'submit',
                        'name' => 'submit',
                        'value' => _('Create new entry!')
                    )
                )
            ),
            array(
                'action' => $_SERVER['PHP_SELF'],
                'method' => 'post'
            )
        );
    }
    /**
     * Creates our html tags.
     * Can be called separate of class instantiation.
     *
     * @param string $tag        The tag to use
     * @param string $string     The string to add to the tag.
     * @param array  $attributes Any attributes to set.
     *                           - This should be in form of assoc array.
     *                           - For example, class with id of frank would
     *                             send attributes variable of:
     *                             array(
     *                                 'class' => 'frank'
     *                             )
     *
     * @return string
     */
    public static function tag($tag, $string, $attributes = array())
    {
        $tag = strtolower($tag);
        $atts = array();
        foreach ((array)$attributes as $item => &$val) {
            $atts[] = sprintf(
                '%s="%s"',
                $item,
                $val
            );
            unset($val);
        }
        $htmltag = sprintf(
            '<%s%s>%s</%s>',
            $tag,
            (
                count($atts) ?
                sprintf(
                    ' %s',
                    implode(' ', $atts)
                ) :
                ''
            ),
            $string
        );
        return $htmltag;
    }
    /**
     * Sanitizes the data for us.
     *
     * @param string $string The data to sanitize.
     *
     * @return string
     */
    private static function _sanitizeItems($string)
    {
        $string = htmlspecialchars(
            $string,
            ENT_QUOTES | ENT_HTML401,
            'utf-8'
        );
        return $string;
    }
    /**
     * Writes the new entry to the database for us.
     *
     * @param array $p The data to insert.
     *
     * @return bool
     */
    public function write($p) {
        /**
         * If the form hasn't been submitted or using bad
         * items we should return without entering anything.
         */
        if (!isset($_POST['submit'])) {
            return;
        }
        /**
         * Just so we can limit potential syntactical errors.
         */
        extract($p);
        /**
         * Initialize these for our prepares
         */
        $vals = [];
        $values = [];
        if ($title) {
            $vals['title'] = ':title';
            $values['title'] = $title;
        }
        if ($bodytext) {
            $vals['bodytext'] = ':bodytext';
            $values['bodytext'] = $bodytext;
        }
        /**
         * If there's no values defined/set, theres nothing for us to do
         * so we should return immediately.
         *
         * I like to return true so we don't halt all operation,
         * though it might work better to add error checking.
         */
        if (count($vals) < 1) {
            return true;
        }
        /**
         * Dynamic build up should use pre-formatted text.
         * This way you only insert what and where necessary.
         */
        $fquery = 'INSERT INTO `%s` (`%s`) VALUES (%s)';
        /**
         * The meat and potatoes, so to speak.
         *
         * This will build the query dynamically.
         */
        $query = sprintf(
            $fquery,
            self::$table,
            implode('`,`', array_keys($vals)),
            implode(',', array_values($vals))
        );
        /**
         * Prepare our query, this will fail if there's a problem so adding
         * tests would be a good idea.
         */
        self::_prepare($query);
        /**
         * Execute the query, notice we're not sending the values directly in
         * the query, we are sending the values with the execute which will
         * escape and parse the values without potential sql injections.
         */
        return self::_execute($values);
    }
    /**
     * Builds the database for us as needed.
     *
     * @return bool
     */
    private static function _buildDB()
    {
        $query = 'CREATE DATABASE IF NOT EXISTS `%s`';
        self::_prepare(
            sprintf(
                $query,
                self::DB_NAME
            )
        );
        $test = self::_execute();
        if (!$test) {
            return false;
        }
        $query = 'CREATE TABLE IF NOT EXISTS `%s` ('
            . '`id` INTEGER NOT NULL AUTO_INCREMENT,'
            . '`title` VARCHAR(150) NOT NULL,'
            . '`bodytext` LONGTEXT NOT NULL,'
            . '`created` DATETIME NOT NULL,'
            . 'PRIMARY KEY (`id`),'
            . 'UNIQUE INDEX `title` (`title`)'
            . ') ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 '
            . 'ROW_FORMAT=DYNAMIC';
        self::_prepare(
            sprintf(
                $query,
                self::$table
            )
        );
        return self::_execute();
    }
}
