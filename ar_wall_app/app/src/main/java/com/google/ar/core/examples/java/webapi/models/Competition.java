package com.google.ar.core.examples.java.webapi.models;

public class Competition {
    public int id;
    public String name;
    public String description;

    @Override
    public String toString() {
        return String.format("%d\n%s\n%s", id, name, description);
    }
}
