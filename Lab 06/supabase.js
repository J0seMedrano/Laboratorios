import { createClient } from  "https://cdn.jsdelivr.net/npm/@supabase/supabase-js/+esm";
const supabaseUrl = "https://bmchdnuassyeoxcvlhnx.supabase.co";
const supabaseKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImJtY2hkbnVhc3N5ZW94Y3ZsaG54Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzE0Njc5MTAsImV4cCI6MjA4NzA0MzkxMH0.iPfaa1KmT4jn-jYn9poKUR7ptrP-e8wVw2tNj37G4p0"
const supabase = createClient(supabaseUrl, supabaseKey);