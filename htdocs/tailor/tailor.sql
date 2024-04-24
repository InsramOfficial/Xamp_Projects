CREATE TABLE customer (
  [id] INT IDENTITY(1,1) PRIMARY KEY,
  [fullname] VARCHAR(255) NOT NULL,
  [phonenumber] VARCHAR(255) NOT NULL,
  [address] NVARCHAR(255) NOT NULL,
  [sex] varchar(200) NOT NULL,
  [email] VARCHAR(100) NOT NULL,
  [comment] VARCHAR(MAX) NOT NULL,
  [city] VARCHAR(100) NOT NULL,
  [created_date] DATETIME DEFAULT GETDATE()
);

CREATE TABLE documents (
  [id] INT IDENTITY(1,1) PRIMARY KEY,
  [title] VARCHAR(50) NOT NULL,
  [detail] NVARCHAR(255) NOT NULL,
  [img] VARCHAR(255) NOT NULL,
  [created_date] DATETIME DEFAULT GETDATE()
);

CREATE TABLE measurement (
  [measurement_id] INT IDENTITY(1,1) PRIMARY KEY,
  [customer_id] INT NOT NULL,
  [part_id] INT NOT NULL,
  [measurement] VARCHAR(255) NOT NULL,
  [created_date] DATETIME DEFAULT GETDATE()
);

CREATE TABLE orders (
  [id] INT IDENTITY(1,1) PRIMARY KEY,
  [customer] INT NOT NULL,
  [description] VARCHAR(255) NOT NULL,
  [amount] DECIMAL(11,2) NOT NULL,
  [received_by] INT NOT NULL,
  [completed] VARCHAR(10) DEFAULT 'No',
  [created_date] DATETIME DEFAULT GETDATE()
);

CREATE TABLE  sms (
  [id] INT IDENTITY(1,1) PRIMARY KEY,
  [customer] VARCHAR(100) NOT NULL,
  [message] VARCHAR(MAX) NOT NULL,
  [date] DATE NOT NULL,
  [created_date] DATETIME DEFAULT GETDATE()
);

CREATE TABLE  staff  (
  [id] INT IDENTITY(1,1) PRIMARY KEY,
  [stafftype] INT NOT NULL,
  [fullname] VARCHAR(255) NOT NULL,
  [address] VARCHAR(255) NOT NULL,
  [phonenumber] NVARCHAR(50) NOT NULL,
  [salary] INT NOT NULL,
  [type] VARCHAR(200),
  [created_date] DATETIME DEFAULT GETDATE()
);

CREATE TABLE  users  (
  [id] INT IDENTITY(1,1) PRIMARY KEY,
  [username] VARCHAR(255) NOT NULL,
  [password] VARCHAR(64) NOT NULL,
  [created_date] DATETIME DEFAULT GETDATE()
);
