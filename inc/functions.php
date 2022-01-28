<?php
define('DB_NAME','D:/Web Source/PHPpractise/crudtxt/data/db.txt');
function seed(){
    $data = array(
        array(
            'id'=>1,
            'fname'=>'Muhit',
            'lname'=>'Asraf',
            'roll'=>'10'
        ),
        array(
            'id'=>2,
            'fname'=>'Habib',
            'lname'=>'Ahsan',
            'roll'=>'03'
        ),
        array(
            'id'=>3,
            'fname'=>'Sibbir',
            'lname'=>'Ahmad',
            'roll'=>'05'
        ),
        array(
            'id'=>4,
            'fname'=>'Adnan',
            'lname'=>'Ahmad',
            'roll'=>'02'
        ),
    );

    $serializeData = serialize($data);
    file_put_contents(DB_NAME,$serializeData,LOCK_EX);
}

function generateReport(){
    $serializeData = file_get_contents(DB_NAME);
    $students = unserialize($serializeData);
    ?>
        <table>
            <tr>
                <th>Name</th>
                <th>Roll</th>
                <th>Action</th>
            </tr>
            <?php
            foreach($students as $student){
                ?>
                <tr>
                    <td><?php printf('%s %s',$student['fname'],$student['lname']); ?></td>
                    <td style="width:35%;"><?php printf('%s',$student['roll']);?></td>
                    <td><?php printf('<a class="ah" href="/crudtxt/index.php?task=edit&id=%s">Edit </a>| <a class="ah" href="/crudtxt/index.php?task=delete&id=%s">Delete </a>',$student['id'],$student['id']); ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
    <?php
}

function addStudent($fname,$lname,$roll){
    $found = false;
    $serializeData = file_get_contents(DB_NAME);
    $students = unserialize($serializeData);
    foreach($students as $_student){
        if ($_student['roll']==$roll) {
            $found = true;
            break;
        }
    }
    if(!$found){
        $newId = getNewId($students);
        $student = array(
            'id'=>$newId,
            'fname'=>$fname,
            'lname'=>$lname,
            'roll'=>$roll
        );
        array_push($students,$student);
        $serializeData = serialize($students);
        file_put_contents(DB_NAME,$serializeData,LOCK_EX);
        return true;
    }
    return false;

}

function getStudent($id){
    $found = false;
    $serializeData = file_get_contents(DB_NAME);
    $students = unserialize($serializeData);
    foreach($students as $student){
        if ($student['id']==$id) {
            return $student;
        }
    }
    return false;
}

function updateStudent($id,$fname,$lname,$roll){
    $serializeData = file_get_contents(DB_NAME);
    $students = unserialize($serializeData);
    $found = false;
    foreach($students as $_student){
        if ($_student['roll']==$roll && $_student['id'] != $id) {
            $found = true;
            break;
        }
    }
    if(!$found){
        $students[$id-1]['fname'] = $fname;
        $students[$id-1]['lname'] = $lname;
        $students[$id-1]['roll'] = $roll;
        $serializeData = serialize($students);
        file_put_contents(DB_NAME,$serializeData,LOCK_EX);
        return true;
    }
    return false;
}

function deleteStudent($id){
    $serializeData = file_get_contents(DB_NAME);
    $students = unserialize($serializeData);
    unset($students[$id-1]);
    $serializeData = serialize($students);
    file_put_contents(DB_NAME,$serializeData,LOCK_EX);
}

function getNewId($students){
    $maxId = max(array_column($students,'id'));
    return $maxId+1;
}