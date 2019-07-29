<?php

namespace Odiseo\SyliusVendorPlugin\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Resource\Model\TimestampableTrait;
use Sylius\Component\Resource\Model\ToggleableTrait;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Symfony\Component\HttpFoundation\File\File;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ChannelInterface;

class Vendor implements VendorInterface
{
    use TranslatableTrait {
        __construct as private initializeTranslationsCollection;
    }
    use TimestampableTrait;
    use ToggleableTrait;

    /** @var int */
    protected $id;

    /** @var string */
    protected $name;

    /** @var string|null */
    protected $slug;

    /** @var string */
    protected $email;

    /** @var ArrayCollection|ChannelInterface[] */
    protected $channels;

    /** @var ArrayCollection|ProductInterface[] */
    protected $products;

    /** @var File */
    protected $logoFile;

    /** @var string */
    protected $logoName;

    /** @var string */
    protected $category;

    public function __construct()
    {
        $this->initializeTranslationsCollection();

        $this->channels = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    protected function createTranslation()
    {
        return new VendorTranslation();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        /** @var VendorTranslationInterface $translation */
        $translation = $this->getTranslation();

        return $translation->getDescription();
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        /** @var VendorTranslationInterface $translation */
        $translation = $this->getTranslation();

        $translation->setDescription($description);
    }

    /**
     * {@inheritdoc}
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * {@inheritdoc}
     */
    public function setSlug(?string $slug = null): void
    {
        $this->slug = $slug;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * {@inheritdoc}
     */
    public function getChannels()
    {
        return $this->channels;
    }

    /**
     * {@inheritdoc}
     */
    public function setChannels(ArrayCollection $channels)
    {
        $this->channels = $channels;
    }

    /**
     * {@inheritdoc}
     */
    public function addChannel(ChannelInterface $channel)
    {
        if (!$this->channels->contains($channel)) {
            $this->channels->add($channel);

            if ($channel instanceof VendorsAwareInterface) {
                $channel->addVendor($this);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeChannel(ChannelInterface $channel)
    {
        if ($this->channels->contains($channel)) {
            $this->channels->removeElement($channel);

            if ($channel instanceof VendorsAwareInterface) {
                $channel->removeVendor($this);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * {@inheritdoc}
     */
    public function setProducts(ArrayCollection $products)
    {
        $this->products = $products;
    }

    /**
     * {@inheritdoc}
     */
    public function addProduct(ProductInterface $product)
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);

            if ($product instanceof VendorsAwareInterface) {
                $product->addVendor($this);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeProduct(ProductInterface $product)
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);

            if ($product instanceof VendorsAwareInterface) {
                $product->removeVendor($this);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setLogoFile(File $file)
    {
        $this->logoFile = $file;

        if (null !== $file) {
            $this->setUpdatedAt(new \DateTime());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getLogoFile()
    {
        return $this->logoFile;
    }

    /**
     * {@inheritdoc}
     */
    public function setLogoName($logoName)
    {
        $this->logoName = $logoName;
    }

    /**
     * {@inheritdoc}
     */
    public function getLogoName()
    {
        return $this->logoName;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
    }


}
