ClarityCdnBundle Emergency
==========================

Nice to see you learning our ClarityCdnBundle - stores media simple and flexible!

**Basics**

* [Installation](#installation)
* [Usage](#usage)

<a name="installation"></a>

## Installation

### Step 1) Get the bundle

#### Simply using composer to install bundle (symfony from 2.1 way)

    "require" :  {
        // ...
        "clarity-project/cdn-bundle": "dev-master",
        // ...
    }

You can try to install ClarityCdnBundle with `deps` file (symfony 2.0 way) like here -  [Symfony doc](http://symfony.com/doc/2.0/cookbook/workflow/new_project_git.html#managing-vendor-libraries-with-bin-vendors-and-deps), 
or with help of `git submodule` functionality - [Git doc](http://git-scm.com/book/en/Git-Tools-Submodules#Starting-with-Submodules).
But it's not tested ways! If you cat do it - just send approve to us, or fork and edit this documentation to solve our doubts =)

### Step 2) Register the namespaces

If you install bundle via composer, use the auto generated autoload.php file and skip this step.
Else you may need to register next namespace manualy:

``` php
<?php
// app/autoload.php
$loader->registerNamespaces(array(
    // ...
    'Clarity\CdnBundle' => __DIR__ . '/../vendor/clarity-project/cdn-bundle/Clarity/CdnBundle',
    // ...
));
```

### Step 3) Register new bundle

Place new line into AppKernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Clarity\CdnBundle\ClarityCdnBundle(),
    );
    // ...
}
```

### Step 4) Configure the bundle

Now, you need to create config section for bundle.
Here is configuration of storages and storage used by default.

``` yaml
clarity_cdn:
    default: "image"
    storage:
        image:
            scheme: "local"
            path: "%kernel.root_dir%/../web/images"
            url: "http://example-site.com/images"
```

<a name="usage"></a>

## Usage

### Your persistent class (ORM Entity or ODM Document)

To upload files with bundle you must use symfony `Symfony\Component\HttpFoundation\File\UploadedFile` class
with help of symfony [File field type](http://symfony.com/doc/current/reference/forms/types/file.html)

But With ClarityCdnBundle you can replace manualy files uploading [Like in this symfony doc](http://symfony.com/doc/current/cookbook/doctrine/file_uploads.html)
by more pretty and effective way:

#### Your entity example with some validation on field:

``` php
// src/Acme/DemoBundle/Entity/Document.php
namespace Acme\DemoBundle\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Document
{
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

    /**
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
```

* Important: It's a symfony base way to handle file uploading with create two class property: 
First for string uploaded file path, second for form usage uploaded file! 

But if you work with images uploading - you can avoid the use of unnecessary file property and provide more functionality for your images uploading 
with using our [ClarityImagesBundle](https://github.com/clarity-project/ClarityImagesBundle)


#### Simple controller example to handle file uploading:

``` php
// ...
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Acme\DemoBundle\Entity\Document;

    // ...
    public function uploadExampleAction(Request $request)
    {
        $document = new Document();
        $form = $this->createFormBuilder($document)
            ->add('file', 'file')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            /** @var \Clarity\CdnBundle\Filemanager\Filemanager $filemanager **/
            $filemanager = $this->container->get('clarity_cdn.filemanager');

            try {
                /** @var \Clarity\CdnBundle\Cdn\Common\ObjectInterface $object **/
                $object = $filemanager->upload(
                    $document->getFile(),
                    'upload_here_subpath', // Not required sub directory to upload file in it, can be generated
                    'uploaded_file_name' . '.' . $document->getFile()->getClientOriginalExtension() // Not required name for uploaded file (original filename used by default)
                );
            } catch (FileException $e) {
                // Handle error
            }

            $document->setPath($object->getUri()); // Set cdn scheme path like 'local://upload_here_subpath/uploaded_file_name.jpg'
            $em->persist($document);
            $em->flush();

            return $this->redirect($this->generateUrl(...));
        }

        return array('form' => $form->createView());
    }
    // ...
```

### Get uploaded file web path (to use in img src or elsewhere...)

Now you can get uploaded file web path by cdn scheme path, stored in entity property by using `clarity_cdn` twig filter or with filemanager directly

#### Simple twig template example:

``` twig
    ...

    <img class="thumbnail" src="{{ clarity_cdn(document.path|default('local://noavatar/noavatar.jpg')) }}" width="100" height="100" alt="avatar" title="avatar">

    ...
```

### Or in controller with help of filemanager service

``` php

    /** @var \Clarity\CdnBundle\Filemanager\Filemanager $filemanager **/
    $filemanager = $this->container->get('clarity_cdn.filemanager');
    $uploadedFileWebPath = $filemanager->get($document->getPath());

    // do something with $uploadedFileWebPath ...
    
```

================

So this way you can create many storages in config.yml to define different local directories to upload files

... to be Continued
