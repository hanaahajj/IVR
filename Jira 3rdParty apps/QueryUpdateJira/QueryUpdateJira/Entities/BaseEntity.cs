﻿using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using Newtonsoft.Json;

namespace QueryUpdateJira.Entities
{
    public class BaseEntity
    {
        [JsonProperty("self")]
        public string Self { get; set; }
    }
}
