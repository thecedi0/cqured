<?php
namespace Api\Controllers;

/**
 * PersonController Class exists in the Api\Controllers namespace
 * A Controller represets the individual URIs client apps access to interact with data
 * URI:  https://api.com/mediaz
 *
 * @category Controller
 */

use Api\Models\PersonModel;

class PersonController extends BaseController
{
    /**
     * Called by parent -> BaseController
     * i use this to initialize dependecies
     * for the controller.
     *
     * @return void
     */
    public function onInit()
    {
        $this->_personModel = new PersonModel;
    }
    /**
     * The Method httpGet() called to handle a GET request
     * URI: POST: https://api.com/values
     * URI: POST: https://api.com/values/2 ,the number 2 in the uri is passed as int ...$id to the method
     *
     * @param integer ...$id
     * @return array|null
     */
    public function httpGet(int...$id): ?array
    {
        // Check if it has a routing parameter
        // i.e https://api.com/person/2
        // where 2 in the uri represents $id[0]
        if (count($id)) {
            // Since this method(httpGet) returns and array,
            // we will have to cast the object returned from (_personModel->getPerson)
            // to an array
            return (array) $this->_personModel->getPerson((int) $id[0]);

        } else {
            $data = $this->_personModel
                ->getPersons(
                    $this->searchValue,
                    $this->pageSize,
                    $this->offset
                );

            // echo $this->_personModel->getSQL();

            $total = $this->_personModel->countPersons($this->searchValue);

        }

        return [
            'data' => $data,
            'page' => $this->page,
            'pageSize' => $this->pageSize,
            'total' => $total,
        ];
    }

    /**
     * The Method httpPost() called to handle a POST request
     * This method requires a body(json) which is passed as the var array $form
     * URI: POST: https://api.com/values
     *
     * @param array $form
     * @return array|null
     */
    public function httpPost(array $form): ?array
    {
        // if you sent a formData for image,
        // then remove tha array type from $form.

        $result = false;
        $msg = '';

        $data = [
            'name' => $form['title'],
            'email' => $form['email'],
            'gender' => (int) ($form['gender']),
        ];

        if ($this->_personModel->addPerson($data)) {
            $result = true;
            $msg = 'Person successfully saved!';
        } else {
            $result = true;
            $msg = 'Something went wrong, Please try again';
        }

        return [
            'success' => $result,
            'msg' => $msg,
            'id' => $this->_personModel->getLastId(),
        ];
    }

    /**
     * The Method httpPut() called to handle a PUT request
     * This method requires a body(json) which is passed as the var array $form and
     * An id as part of the uri.
     * URI: POST: https://api.com/values/2 the number 2 in the uri is passed as int $id to the method
     *
     * @param array $form
     * @param integer $id
     * @return array|null
     */
    public function httpPut(array $form, int $id): ?array
    {

        if (empty($form['name']) || empty($form['gender']) || empty($form['email'])) {
            return [
                'success' => false,
                'msg' => 'All fields are required',
            ];
        }
        return $this->_editPerson($form, $id);

    }

    /**
     * Edit Person Info From List
     *
     * @param array $form
     * @param integer $id
     * @return array|null
     */
    private function _editPerson(array $form, int $id): ?array
    {
        $data = [
            'name' => $form['name'],
            'email' => $form['email'],
            'gender' => (int) ($form['gender']),
        ];
        // check for any changes

        $result = false;
        $msg = '';

        if ($this->_personModel->updatePerson($data, $id)) {
            $result = true;
            $msg = 'Person successfully updated!';
        } else {
            $result = true;
            $msg = 'Something went wrong, please try again';
        }

        return [
            'success' => $result,
            'msg' => $msg,
        ];
    }

    /**
     * The Method httpDelete() called to handle a DELETE request
     * URI: POST: https://api.com/values/2 ,the number 2 in the uri is passed as int ...$id to the method
     *
     * @param integer $id
     * @return array|null
     */
    public function httpDelete(int $id): ?array
    {
        // code here
        $status = $this->_personModel->deletePerson($id);
        return [
            'success' => $status,
        ];
    }
}
