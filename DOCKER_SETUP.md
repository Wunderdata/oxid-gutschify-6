# Docker Setup for OXID 6.x Module Testing

This guide helps you set up a Docker environment to test the Gutschify module for OXID 6.x.

## Prerequisites

- Docker installed (version 20.10+)
- Docker Compose installed (version 2.0+)
- At least 2GB free disk space

## Quick Start

### Option 1: Using Official OXID Docker SDK (Recommended)

The official OXID Docker SDK is the best way to test OXID modules:

1. **Clone the Docker SDK:**
   ```bash
   git clone https://github.com/OXID-eSales/docker-eshop-sdk.git oxid6-test
   cd oxid6-test
   ```

2. **Set up the environment:**
   ```bash
   make setup
   make addbasicservices
   ```

3. **Start the services:**
   ```bash
   make up
   ```

4. **Install OXID 6.x:**
   - Follow the installation wizard at `http://localhost`
   - Use database credentials from the docker-compose.yml

5. **Install the Gutschify module:**
   ```bash
   # Copy module to the OXID installation
   cp -r /path/to/oxid-gutschify-6 source/modules/gutschify
   ```

6. **Activate the module:**
   - Log in to OXID Admin
   - Go to Extensions → Modules
   - Activate "Gutschify Embedded Home Widget"

### Option 2: Using Custom Docker Compose

This repository includes a basic `docker-compose.yml` for testing:

1. **Start the containers:**
   ```bash
   docker-compose up -d
   ```

2. **Install OXID 6.x manually:**
   - Download OXID 6.x from https://www.oxid-esales.com
   - Extract to the `oxid6-oxid` volume
   - Access the web container: `docker exec -it oxid6-web bash`
   - Run OXID installation

3. **Install the module:**
   - The module is already mounted at `/var/www/html/source/modules/gutschify`
   - Activate in OXID Admin

## Using Official Docker SDK (Detailed)

The [OXID Docker SDK](https://github.com/OXID-eSales/docker-eshop-sdk) provides:

- Pre-configured PHP, MySQL, Apache
- Optional services: Selenium, Elasticsearch
- Easy module testing environment
- Consistent development setup

### Setup Steps:

```bash
# 1. Clone the SDK
git clone https://github.com/OXID-eSales/docker-eshop-sdk.git my-oxid6-project
cd my-oxid6-project

# 2. Initialize the project
make setup

# 3. Add basic services (PHP, MySQL, Apache)
make addbasicservices

# 4. Start all services
make up

# 5. Check service status
make ps
```

### Installing OXID 6.x:

1. Download OXID 6.x CE from the official website
2. Extract to the project directory
3. Access the installation wizard at `http://localhost`
4. Complete the installation with database credentials from `.env`

### Installing the Gutschify Module:

```bash
# Copy module to source/modules directory
cp -r /path/to/oxid-gutschify-6 source/modules/gutschify

# Clear cache
docker-compose exec oxid-web rm -rf tmp/*

# Activate module in OXID Admin
```

## Testing the Module

1. **Configure the module:**
   - Go to Extensions → Modules → Gutschify → Settings
   - Set `gutschify_base_url`: `https://gutschify.xxiii.tools`
   - Set `organization_id`: Your organization UUID
   - Set `collection_slug`: `default` (or your collection slug)

2. **Add widget to a page:**
   - Go to Content → CMS Pages
   - Edit a page
   - Add: `[{oxid_widget ident="gutschify" widget="gutschify_widget"}]`

3. **View the page:**
   - Navigate to the page in the frontend
   - Verify the Gutschify content loads correctly

## Troubleshooting

### Container won't start:
```bash
# Check logs
docker-compose logs

# Restart containers
docker-compose restart
```

### Module not found:
```bash
# Verify module is in correct location
docker-compose exec oxid-web ls -la source/modules/gutschify

# Clear OXID cache
docker-compose exec oxid-web rm -rf tmp/*
```

### Database connection issues:
```bash
# Check database container
docker-compose ps oxid6-mysql

# Check database logs
docker-compose logs oxid6-mysql
```

## Resources

- [OXID Docker SDK](https://github.com/OXID-eSales/docker-eshop-sdk)
- [OXID 6.x Documentation](https://docs.oxid-esales.com/)
- [Docker Documentation](https://docs.docker.com/)

## Notes

- The custom `docker-compose.yml` in this directory is a basic setup
- For production-like testing, use the official OXID Docker SDK
- Always test module changes in the Docker environment before deployment

