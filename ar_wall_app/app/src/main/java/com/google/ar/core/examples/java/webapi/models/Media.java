package com.google.ar.core.examples.java.webapi.models;

public class Media {
    public int id;
    public String url;
    public String name;
    public String description;
    public int artistId;
    public String mediaType;

    @Override
    public String toString() {
        return String.format("%d\n%s\n%s\n%s\n%d\n%s", id, url, name, description, artistId, mediaType);
    }
}
