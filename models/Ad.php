<?php

require_once 'BaseModel.php';

class Park extends Model {

    protected static $table = 'parks';

    public static function find($id)
    {
        if(isset($id) && is_int($id)) {

            self::dbConnect();

            $query = 'SELECT * FROM parks WHERE id = :id';
            $stmt = self::$dbc->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $instance = null;
            if ($result) {
                $instance = new static;
                $instance->attributes = $result;
            }
            return $instance;
        }
    }

    public static function all()
    {
        self::dbConnect();
        $stmt = self::$dbc->query('SELECT * FROM parks');
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $instance = null;
        if ($result) {
            $instance = new static;
            $instance->attributes = $result;
        }
        return $instance;
    }

    public function save()
    {
        if (isset($this->attributes['id'])) {
            $this->update($this->attributes['id']);
        } else {
            $this->insert();
        }
    }

    protected function insert()
    {
        self::dbConnect();
        $query = 'INSERT INTO parks
                    (name, description, area_in_acres, description, location)
                    VALUES (:name, :description, :area_in_acres, :date_established, :location);';

        $stmt = self::$dbc->prepare($query);
        $stmt->bindValue(':name', Input::get('name'), PDO::PARAM_STR);
        $stmt->bindValue(':description', Input::get('description'), PDO::PARAM_STR);
        $stmt->bindValue(':area_in_acres', Input::get('area_in_acres'), PDO::PARAM_STR);
        $stmt->bindValue(':date_established', Input::get('date_established'), PDO::PARAM_STR);
        $stmt->bindValue(':location', Input::get('location'), PDO::PARAM_STR);
        $stmt->execute();
    }

    protected function update($id)
    {
        self::dbConnect();
        $query = 'UPDATE parks
                    SET name = :name,
                        description = :description,
                        area_in_acres = :area_in_acres,
                        date_established= :date_established,
                        location = :location
                        WHERE id = :id';

        $stmt = self::$dbc->prepare($query);
        $stmt->bindValue(':name', Input::get('name'), PDO::PARAM_STR);
        $stmt->bindValue(':description', Input::get('description'), PDO::PARAM_STR);
        $stmt->bindValue(':area_in_acres', Input::get('area_in_acres'), PDO::PARAM_STR);
        $stmt->bindValue(':date_established', Input::get('date_established'), PDO::PARAM_STR);
        $stmt->bindValue(':location', Input::get('location'), PDO::PARAM_STR);
        $stmt->bindValue(':location', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}
